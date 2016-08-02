<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Requests\UserEditFormRequest;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;

class UsersController extends Controller
{
    public function index() {
		$users = User::all();
		return view('backend.users.index', compact('users'));
	}
    public function edit( $id ) {
		$user = User::whereId( $id )->firstOrFail();
		$roles = Role::all();
		$selectedRoles = $user->roles->lists('id')->toArray();
		return view('backend.users.edit', compact('user', 'roles', 'selectedRoles'));
	}
    public function update( $id, UserEditFormRequest $request ) {
		$user = User::whereId( $id )->firstOrFail();
		$user->first_name = $request->get('first_name');
		$user->last_name = $request->get('last_name');
		$user->email = $request->get('email');
		$password = $request->get('password');
		if( trim($password) ) {
			$user->password = Hash::make($password);
		}
		$user->save();
		$user->saveRole($request->get('role'));

		return redirect( action('Admin\UsersController@edit', $user->id) )->with('status', 'User updated successfully!');
	}
}
