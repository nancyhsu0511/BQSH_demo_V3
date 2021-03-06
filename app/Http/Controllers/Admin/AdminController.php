<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests;
use App\Http\Requests\TeacherImportrequest;
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
		$page_mode = 'list';
		$students = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 1)
					->orderBy('created_at', 'desc')
					->paginate(10);
		return view('admin.acc_students', compact('students', 'nav_tab', 'page_tab', 'page_mode'));
	}
    public function course_students( $course_code ) {
		$nav_tab = 'accounts';
		$page_tab = 'students';
		$page_mode = 'list';
		$students = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->join('classes', 'users.id', '=', 'classes.student_id')
					->join('courses', 'courses.id', '=', 'classes.course_id')
					->where('role_user.role_id', 1)
					->where('courses.course_code', $course_code)
					->select('users.*', 'classes.seat_no')
					->orderBy('users.created_at', 'asc')
					->paginate(10);
		return view('admin.acc_students', compact('students', 'course_code', 'nav_tab', 'page_tab', 'page_mode'));
	}
    public function search_student( Request $request ) {
		// wtf( $request->all() );
		$nav_tab = 'accounts';
		$page_tab = 'students';
		$page_mode = 'search';
		$students = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->join('classes', 'users.id', '=', 'classes.student_id')
					->join('courses', 'courses.id', '=', 'classes.course_id')
					->where('role_user.role_id', 1)
					->where('users.id', $request->get('keyw'))
					->select('users.*', 'courses.course_name', 'courses.course_code', 'classes.seat_no')
					->orderBy('users.created_at', 'asc')
					->paginate(10);
		return view('admin.acc_students', compact('students', 'nav_tab', 'page_tab', 'page_mode'));
	}
    public function add_student_course( Request $request ) {
		$students = $request->get('student_ids');
		$course_code = $request->get('course_code');
		$course = DB::table('courses')->where('course_code', $course_code)->get();
		if( count($course) ) {
			// wtf( $request->all() );
			if( count($students) ) {
				$max_seat = DB::table('classes')->where('course_id', $course[0]->id)->max('seat_no');
				$max_seat = ($max_seat ? $max_seat : 1);
				foreach( $students as $i => $id ) {
					$check = DB::table('classes')->where('course_id', $course[0]->id)->where('student_id', $id)->count();
					if( !$check ) {
						DB::table('classes')->insert([
							'course_id'	=> $course[0]->id,
							'student_id'=> $id,
							'seat_no'	=> ++$max_seat
						]);
					}
				}
				return back()->with('status', 'Course assigned successfully!');
			} else {
				return back()->with('error', 'Please select students to add!');
			}
		} else {
			return back()->with('error', 'Invalid course code!');
		}
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
    public function search_teacher( Request $request ) {
		// wtf( $request->all() );
		$teacher_id = $request->get('keyw');
		$teacher_id = trim( str_replace('t', '', $teacher_id) );

		$nav_tab = 'accounts';
		$page_tab = 'teachers';
		$teachers = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 2)
					->where('users.id', $teacher_id)
					->paginate(10);
		return view('admin.acc_teachers', compact('teachers', 'nav_tab', 'page_tab'));
	}
    public function import_csv( TeacherImportrequest $request ) {
		if ($request->hasFile('import_csv')) {
			$csv_file = $request->file('import_csv');
			if($csv_file->isValid()) {
				$destinationPath = 'uploads/csv';
				$extension = $csv_file->getClientOriginalExtension();
				$attached_csv = time().'_'.rand(11111,99999).'.'.$extension;
				$csv_file->move($destinationPath, $attached_csv);
			}
		}
		$handle = fopen($destinationPath.'/'.$attached_csv, "r");
		$i = 0;
		while($data = fgetcsv($handle, 5000, ",")) {
			if( !$i ) { $i++; continue; }

			$data = array_map("utf8_encode", $data); //added
			$data = array_map("trim", $data);
			// wtf($data);

			if( filter_var($data[1], FILTER_VALIDATE_EMAIL) ) {
				$check = DB::table('users')->where('email', $data[1])->count();
				if( !$check ) {
					$now = date('Y-m-d H:i:s');
					$pass = random_string(10);
					$pass = 'azakaban';		// temp pass for now
					$pass = Hash::make( $pass );
					DB::table('users')->insert([
						'first_name'=> $data[0],
						'last_name'	=> '',
						'email'		=> $data[1],
						'password'	=> $pass,
						'created_at'=> $now,
						'updated_at'=> $now,
					]);
				}
			}
			$i++;
		}
		return back()->with('status', 'Import successful!');
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
		$pass = 'pw'.($request->get('user_role') == 1 ? 'student' : ($request->get('user_role') == 2 ? 'teacher' : 'admin'));		// temp pass for now
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

	public function administer_class() {
		$nav_tab = 'classes';
		$classes = DB::table('classrooms')
					->orderBy('updated_at', 'desc')
					->paginate(10);
		return view('admin.classes', compact('classes', 'nav_tab'));
	}
	public function process_class( Request $request ) {
		$class_code = $request->get('class_code');
		$class_name = $request->get('class_name');
		$seats		= $request->get('seats');
		$act		= $request->get('act');

		switch( $act ) {
			case 'add':
				$check = DB::table('classrooms')
						->where('class_code', $class_code)->count();
				if( $check ) {
					return back()->with('error', 'Duplicate class code. Please enter different class code.');
				}

				DB::table('classrooms')->insert([
					'class_code'	=> $class_code,
					'class_name'	=> $class_name,
					'seats'			=> $seats,
					'created_at'	=> date('Y-m-d H:i:s')
				]);
				return back()->with('status', 'Class added successfully!');
				break;
			case 'edit':
				$class_id	= $request->get('class_id');
				$classroom	= DB::table('classrooms')
								->where('id', $class_id)->get();
				if( $classroom[0]->class_code != $class_code ) {
					$check = DB::table('classrooms')
							->where('class_code', $class_code)->count();
					if( $check ) {
						return back()->with('error', 'Duplicate class code. Please enter different class code.');
					}
				}

				DB::table('classrooms')
				->where('id', $class_id)->update([
					'class_code'	=> $class_code,
					'class_name'	=> $class_name,
					'seats'			=> $seats,
				]);
				return back()->with('status', 'Class updated successfully!');
				break;
		}
		return back();
	}
	public function delete_class( $id ) {
		DB::table('classrooms')->where('id', $id)->delete();
		DB::table('classroom_association')->where('classroom_id', $id)->delete();
		return back()->with('status', 'Class deleted successfully!');
	}
	public function class_search( Request $request ) {
		$class_code = $request->get('class_code');
		$nav_tab = 'classes';
		if( $class_code ) {
			$classes = DB::table('classrooms')
						->where('class_code', $class_code)
						->paginate(10);
		} else {
			$classes = DB::table('classrooms')
						->paginate(10);
		}
		return view('admin.classes', compact('classes', 'nav_tab'));
	}
    public function import_class_csv( Request $request ) {
		$allowed_mime = array('text/plain', 'text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel');

		if ($request->hasFile('import_csv')) {
			$csv_file = $request->file('import_csv');
			$mime = $csv_file->getClientMimeType();

			if( in_array($mime, $allowed_mime) ) {
				if($csv_file->isValid()) {
					$destinationPath = 'uploads/csv';
					$extension = $csv_file->getClientOriginalExtension();
					$attached_csv = time().'_'.rand(11111,99999).'.'.$extension;
					$csv_file->move($destinationPath, $attached_csv);
				}
			} else {
				return back()->with('error', 'The import csv must be a file of type: csv');
			}
		}
		$handle = fopen($destinationPath.'/'.$attached_csv, "r");
		$i = 0;
		while($data = fgetcsv($handle, 5000, ",")) {
			if( !$i ) { $i++; continue; }

			$data = array_map("utf8_encode", $data); //added
			$data = array_map("trim", $data);
			// wtf($data);

			$check = DB::table('classrooms')
					->where('class_code', $data[0])->count();
			if( !$check ) {
				DB::table('classrooms')->insert([
					'class_code'	=> $data[0],
					'class_name'	=> $data[1],
					'seats'			=> $data[2],
					'created_at'	=> date('Y-m-d H:i:s')
				]);
			}
		}
		return back()->with('status', 'Import successful!');
	}
}
