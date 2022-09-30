<?php

namespace Vanguard\Http\Controllers\Web\UserTypes\TypesUser;

use Cache;
use Vanguard\Http\Controllers\Controller;
use Vanguard\Http\Requests\UserTypes\CreateTypeRequest;
// use Vanguard\Http\Requests\UserTypes\UpdateTypeRequest;
use Vanguard\Repositories\UserTypes\TypeRepository;
use Vanguard\Repositories\User\UserRepository;
use Vanguard\Type;
// use Vanguard\Http\Requests\Request;
use Illuminate\Http\Request as Req;
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

    public function edit(TypeRepository $type, $id)
    {
        // $data = $type->find(1);
        // echo json_encode($id);
        // die();
        return view('UserTypes.permission.action.create-edit', [
            'type' => $type->find($id),
            'edit' => true
        ]);
    }

    public function update($id, Req $request)
    {
        // $data = $type->id;
        $data = [
            'ut_name' => $request['ut_name'],
            'ut_displayname' => $request['display_name'],
            'ut_desc' => $request['description']
        ];
        // echo json_encode($data);
        // die();

        // $this->types->update($id, $request->all());
        Type::where('ut_id', $id)->update($data);
        return redirect()->route('types.index')
            ->withSuccess(__('Type updated successfully.'));
    }

    public function destroy($id)
    {
        // echo json_encode($id);
        // die();
        Type::where('ut_id', $id)->delete();
        return redirect()->route('types.index')
            ->withSuccess(__('Type deleted successfully.'));
    }


}
