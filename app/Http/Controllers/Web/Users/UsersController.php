<?php

namespace Vanguard\Http\Controllers\Web\Users;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Vanguard\Events\User\Deleted;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\User\CreateUserRequest;
use Vanguard\Repositories\Activity\ActivityRepository;
use Vanguard\Repositories\Country\CountryRepository;
use Vanguard\Repositories\Role\RoleRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Repositories\UserTypes\TypeRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
use Vanguard\Type;
use Vanguard\Province;
use Vanguard\Dati2;

/**
 * Class UsersController
 * @package Vanguard\Http\Controllers
 */
class UsersController extends Controller
{
    public function __construct(private UserRepository $users)
    {
    }

    /**
     * Display paginated list of all users.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $users = $this->users->paginate($perPage = 20, $request->search, $request->status);

        $statuses = ['' => __('All')] + UserStatus::lists();

        return view('user.list', compact('users', 'statuses'));
    }

    /**
     * Displays user profile page.
     *
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        return view('user.view', compact('user'));
    }

    /**
     * Displays form for creating a new user.
     *
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return Factory|View
     */
    public function create(CountryRepository $countryRepository, Province $province, TypeRepository $type, RoleRepository $roleRepository)
    {
        // $data = Type::all();
        // $test = Province::all()->where('ut_id', '2');
        // echo json_encode($test);
        // die();
        return view('user.add', [
            'countries' => $this->parseCountries($countryRepository),
            'roles' => $roleRepository->lists(),
            'statuses' => UserStatus::lists(),
            'province' => Province::all()
            // 'type' => $type->lists()
        ]);
    }

    public function getProvince(Request $request)
    {
        $id = $request->tipeID;

        $option = "<option value='0'>Select a Province</option>";
        if($id === '4')
        {
            $provinces = Province::all()->where('ut_id', $id);
            foreach ($provinces as $province)
            {
                $option .= '<option value="'.$province->prop_id.'">'.$province->prop_nama.'</option>';
            }
        }
        else
        {
            $provinces = Province::all()->where('ut_id', '4');
            foreach ($provinces as $province)
            {
                $option .= '<option value="'.$province->prop_id.'">'.$province->prop_nama.'</option>';
            }
        }
        return $option;
    }

    public function getRegency(Request $request)
    {
        $id = $request->provID;
        $regencies = Dati2::all()->where('prop_id', $id);
        // return response()->json($regency);

        $option = "<option>Select a Regency</option>";
        foreach ($regencies as $regency)
        {
            $option .= '<option value="'.$regency->dati2_id.'">'.$regency->dati2_nama.'</option>';
        }
        return $option;
    }

    /**
     * Parse countries into an array that also has a blank
     * item as first element, which will allow users to
     * leave the country field unpopulated.
     *
     * @param CountryRepository $countryRepository
     * @return array
     */
    private function parseCountries(CountryRepository $countryRepository)
    {
        return [0 => __('Select a Country')] + $countryRepository->lists()->toArray();
    }

    private function parseType(TypeRepository $typeRepo)
    {
        return [0 => __('Select a Type')] + $typeRepo->lists()->toArray();
    }

    /**
     * Stores new user into the database.
     *
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function store(CreateUserRequest $request)
    {
        // When user is created by administrator, we will set his
        // status to Active by default.

        $data = $request->all() + [
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now()
        ];

        if (! data_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if (! data_get($data, 'username')) {
            $data['username'] = null;
        }

        $this->users->create($data);

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Displays edit user form.
     *
     * @param User $user
     * @param CountryRepository $countryRepository
     * @param RoleRepository $roleRepository
     * @return Factory|View
     */
    public function edit(User $user, CountryRepository $countryRepository, TypeRepository $type, Province $province, RoleRepository $roleRepository)
    {
        return view('user.edit', [
            'edit' => true,
            'user' => $user,
            'countries' => $this->parseCountries($countryRepository),
            'roles' => $roleRepository->lists(),
            'statuses' => UserStatus::lists(),
            'province' => Province::all(),
            'type' => $this->parseType($type),
            'socialLogins' => $this->users->getUserSocialLogins($user->id)
        ]);
    }

    /**
     * Removes the user from database.
     *
     * @param User $user
     * @return $this
     */
    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return redirect()->route('users.index')
                ->withErrors(__('You cannot delete yourself.'));
        }

        $this->users->delete($user->id);

        event(new Deleted($user));

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }
}
