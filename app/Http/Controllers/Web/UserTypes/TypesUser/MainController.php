<?php

namespace Vanguard\Http\Controllers\Web\UserTypes\TypesUser;

use Cache;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\UserTypes\CreateTypeRequest;
use Vanguard\Repositories\UserTypes\TypeRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Type;
// use Illuminate\Http\Request as Req;
// use Vanguard\Http\Controllers\Web\UserTypes\TypesUser\DbController as Model;

class MainController extends Controller
{
    public function __construct(private TypeRepository $types)
    {
    }

    public function index()
    {
        return view('UserTypes.permission.index', ['types' => $this->types->getAllWithUsersCount()]);
    }

    public function create()
    {
        return view('UserTypes.permission.action.create-edit', ['edit' => false]);
    }

    public function post(CreateTypeRequest $request)
    {
        $this->types->create($request->all());

        return redirect()->route('types.index')
            ->withSuccess(__('Type created successfully.'));
    }

    public function edit(TypeRepository $type)
    {
        // $data = Type::all();
        // echo json_encode($type);
        // die();
        return view('UserTypes.permission.action.create-edit', [
            'type' => $type->lists(),
            'edit' => true
        ]);
    }


}
