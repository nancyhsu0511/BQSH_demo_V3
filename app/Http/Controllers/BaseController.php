<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class BaseController extends Controller
{
    public function index() {
		if( Auth::check() ) {
			if( Auth::user()->hasRole('admin') ) {
				return redirect( action('Admin\AdminController@index') );
			}
			if( Auth::user()->hasRole('student') ) {
				return redirect( action('Student\StudentController@index') );
			}
			if( Auth::user()->hasRole('teacher') ) {
				return redirect( action('Teacher\TeacherController@index') );
			}
		}
		return view('index');
	}
}
