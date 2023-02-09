<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Xem người dùng|Thêm người dùng|Sửa người dùng|Xoá người dùng', ['only' => ['index','store', 'show']]);
        $this->middleware('permission:Thêm người dùng', ['only' => ['create','store']]);
        $this->middleware('permission:Sửa người dùng', ['only' => ['edit','update']]);
        $this->middleware('permission:Xoá người dùng', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('users'))
            ->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'birthday' => 'required|date_format:Y-m-d|before:now',
            'phone' => 'required|digits:10',
            'identity' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = FacadesHash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        $notification = [
            'message' => 'Thêm người dùng thành công',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.users.index')
                        ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('admin.users.show', compact('user', 'roles', 'userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'birthday' => 'required|date_format:Y-m-d|before:now',
            'phone' => 'required|digits:10',
            'identity' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = FacadesHash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        FacadesDB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        $notification = [
            'message' => 'Cập nhật người dùng thành công',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.users.index')
                        ->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        $notification = [
            'message' => 'Xoá người dùng thành công',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.users.index')
                        ->with($notification);
    }
}
