<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Requests\AdminUserSignupRequest;
use App\Http\Controllers\Controller;

use DB;

class AdminController extends Controller
{
    public function index() {
		return view('admin.admin_dashboard');
	}
    public function accounts() {
		return view('admin.account_index');
	}
    public function acc_students() {
		$nav_tab = 'accounts';
		$page_tab = 'students';
		$students = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 1)
					->orderBy('created_at', 'desc')
					->paginate(10);
		return view('admin.acc_students', compact('students', 'nav_tab', 'page_tab'));
	}
    public function acc_teachers() {
		$nav_tab = 'accounts';
		$page_tab = 'teachers';
		$teachers = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 2)
					->orderBy('created_at', 'desc')
					->paginate(10);
		return view('admin.acc_teachers', compact('teachers', 'nav_tab', 'page_tab'));
	}
    public function acc_admins() {
		$nav_tab = 'accounts';
		$page_tab = 'admins';
		$admins = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 3)
					->orderBy('created_at', 'desc')
					->paginate(10);
		return view('admin.acc_admins', compact('admins', 'nav_tab', 'page_tab'));
	}
    public function add_members(AdminUserSignupRequest $request) {
		$now = date('Y-m-d H:i:s');
		$pass = random_string(10);
		$pass = 'azakaban';		// temp pass for now
		$pass = Hash::make( $pass );
		$user_id = DB::table('users')->insertGetId([					// add new user
			'first_name'=> $request->get('first_name'),
			'last_name'	=> $request->get('last_name'),
			'email'		=> $request->get('email'),
			'password'	=> $pass,
			'created_at'=> $now,
			'updated_at'=> $now,
		]);
		DB::table('role_user')->insert([
			'user_id'	=> $user_id,
			'role_id'	=> $request->get('user_role')
		]);
		$role_name = $request->get('user_role') == 1 ? 'Student' : ($request->get('user_role') == 2 ? 'Teacher' : 'Administrator');
		return back()->with('status', $role_name.' added successfully!');
	}
}
