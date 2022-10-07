<?php

namespace Vanguard\Http\Controllers\Web\Users;

use App\Helpers\Helper;
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
use Vanguard\Repositories\Province\ProvinceRepository;
use Vanguard\Repositories\UserTypes\TypeRepository;
use Vanguard\Support\Enum\UserStatus;
use Vanguard\User;
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
        $permission = Helper::getPermission(auth()->user());
        $users = User::whereIn('role_id', $permission)->paginate($perPage = 20);
        // ->paginate($perPage = 20, $request->search, $request->status);
        // $users = $this->users->;
        // dd($users);
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
            'province' => Province::pluck('prop_nama', 'prop_id'),
            'regency' => Dati2::pluck('dati2_nama', 'dati2_id')
        ]);
    }

    public function getProvince(Request $request)
    {
        $option = "<option value='0'>Select a Province</option>";
        $provinces = Province::all();
        foreach ($provinces as $province) {
            $option .= '<option value="' . $province->prop_id . '">' . $province->prop_nama . '</option>';
        }
        return $option;
    }

    public function getRegency(Request $request)
    {
        $id = $request->provID;
        $regencies = Dati2::where('prop_id', $id)->get();

        $option = "<option value='0'>Select a Regency</option>";
        foreach ($regencies as $regency) {
            $option .= '<option value="' . $regency->dati2_id . '">' . $regency->dati2_nama . '</option>';
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
        // if ($request->role_id !== '8') $request->dati2_id
        $data = $request->all() + [
            'status' => UserStatus::ACTIVE,
            'email_verified_at' => now()
        ];

        if (!data_get($data, 'country_id')) {
            $data['country_id'] = null;
        }

        // Username should be updated only if it is provided.
        if (!data_get($data, 'username')) {
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
    public function edit(User $user, CountryRepository $countryRepository, Province $province, Dati2 $regency, RoleRepository $roleRepository)
    {
        // $test = $user->province_id;
        // echo json_encode($test);
        // die();
        return view('user.edit', [
            'edit' => true,
            'user' => $user,
            'countries' => $this->parseCountries($countryRepository),
            'roles' => $roleRepository->lists(),
            'statuses' => UserStatus::lists(),
            'province' => $this->parseProvince(),
            'regency' => $this->parseRegency($user->province_id),
            'socialLogins' => $this->users->getUserSocialLogins($user->id)
        ]);
    }

    private function parseProvince()
    {
        return [0 => __('Select a Province')] + Province::pluck('prop_nama', 'prop_id')->toArray();
    }

    private function parseRegency($prop_id)
    {
        return [0 => __('Select a Regency')] + Dati2::where('prop_id', $prop_id)->pluck('dati2_nama', 'dati2_id')->toArray();
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
