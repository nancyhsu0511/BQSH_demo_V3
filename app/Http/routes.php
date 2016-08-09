<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'BaseController@index');
Route::get('/home', 'BaseController@index');

Route::get('login/{type?}', 'Auth\AuthController@getLogin');
Route::post('login/{type?}', 'Auth\AuthController@postLogin');

Route::get('users/register', 'Auth\AuthController@getRegister');
Route::post('users/register', 'Auth\AuthController@postRegister');

Route::get('users/logout', 'Auth\AuthController@getLogout');

Route::group(array('prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'manager'), function() {
	Route::get('/', 'AdminController@index');
	Route::get('accounts','AdminController@accounts');

	Route::get('accounts/students','AdminController@acc_students');
	Route::get('accounts/students/{course_code?}','AdminController@course_students');
	Route::post('accounts/students','AdminController@add_members');
	Route::post('accounts/students/search','AdminController@search_student');
	Route::post('accounts/students/add_course','AdminController@add_student_course');

	Route::get('accounts/teachers','AdminController@acc_teachers');
	Route::post('accounts/teachers','AdminController@add_members');
	Route::post('accounts/teachers/search_teacher','AdminController@search_teacher');
	Route::post('accounts/teachers/import','AdminController@import_csv');

	Route::get('accounts/administrators','AdminController@acc_admins');
	Route::post('accounts/administrators','AdminController@add_members');

	Route::get('classes','AdminController@administer_class');
	Route::post('classes','AdminController@class_search');

	//------------------------//
	Route::get('users', [ 'as' => 'admin.user.index', 'uses' => 'UsersController@index']);
	Route::get('roles', 'RolesController@index');

	Route::get('roles/create', 'RolesController@create');
	Route::post('roles/create', 'RolesController@store');

	Route::get('users/{id?}/edit', 'UsersController@edit');
	Route::post('users/{id?}/edit','UsersController@update');
});

Route::group( array('prefix' => 'student', 'namespace' => 'Student', 'middleware' => 'smanager'), function() {
	Route::get('/', 'StudentController@index');
	Route::get('/subject', 'StudentController@index');

	Route::get('subject/{alias?}', 'StudentController@dashboard');
	Route::post('subject/{alias?}', 'StudentController@add_course');

	Route::get('subject/{alias?}/{course_code?}/records', 'StudentController@lesson_scores');

	Route::get('subject/{alias?}/{course_code?}/concept/{id?}', 'StudentController@lesson_concept');
	Route::get('subject/{alias?}/{course_code?}/question/{id?}', 'StudentController@lesson_question');
	Route::post('subject/{alias?}/{course_code?}/question/{id?}', 'StudentController@store_answer');
});
Route::group( array('prefix' => 'teacher', 'namespace' => 'Teacher', 'middleware' => 'tmanager'), function() {
	Route::get('/', 'TeacherController@index');
	Route::get('/subject', 'TeacherController@index');
	Route::get('subject/{alias?}', 'TeacherController@dashboard');

	Route::get('subject/{alias?}/courses', 'TeacherController@course_list');
	Route::post('subject/{alias?}/courses', 'TeacherController@course_create');

	Route::get('subject/{alias?}/courses/{id?}/edit', 'TeacherController@course_edit');
	Route::post('subject/{alias?}/courses/{id?}/edit', 'TeacherController@course_update');
	Route::get('subject/{alias?}/courses/{id?}/delete', 'TeacherController@course_delete');

	Route::get('subject/{alias?}/courses/{course_code?}/student_list', 'TeacherController@student_list');

	Route::get('subject/{alias?}/lessons', 'TeacherController@lesson_list');
	Route::post('subject/{alias?}/lessons', 'TeacherController@lesson_create');

	Route::get('subject/{alias?}/lessons/{id?}', 'TeacherController@lesson_details');

	// Route::get('subject/{alias?}/courses/{course_id?}/lessons', 'TeacherController@lesson_list');
	// Route::post('subject/{alias?}/courses/{course_id?}/lessons', 'TeacherController@lesson_create');

	Route::get('subject/{alias?}/lessons/{id?}/edit', 'TeacherController@lesson_edit');
	Route::post('subject/{alias?}/lessons/{id?}/edit', 'TeacherController@lesson_update');
	Route::get('subject/{alias?}/lessons/{id?}/delete', 'TeacherController@lesson_delete');

	// Route::get('subject/{alias?}/courses/{course_id?}/lessons/{id?}/edit', 'TeacherController@lesson_edit');
	// Route::post('subject/{alias?}/courses/{course_id?}/lessons/{id?}/edit', 'TeacherController@lesson_update');
	// Route::get('subject/{alias?}/courses/{course_id?}/lessons/{id?}/delete', 'TeacherController@lesson_delete');

	// Teaching Zone
	Route::get('subject/{alias?}/teaching_zone', 'TeacherController@teaching_zone');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}', 'TeacherController@lesson_list_content');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/copy_course', 'TeacherController@copy_course');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/copy_course', 'TeacherController@copyncreate_course');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/share_course', 'TeacherController@share_course');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/share_course', 'TeacherController@set_shared_course');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/del_share_course/{teacher_id?}', 'TeacherController@del_shared_course');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}', 'TeacherController@lesson_list_content_store');

	Route::get('subject/{alias?}/teaching_zone/{course_code?}/class', 'TeacherController@class_begins');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/publish_concept/{lesson_id?}', 'TeacherController@publish_concept');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}', 'TeacherController@publish_question');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}', 'TeacherController@save_closing_time');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}/student_answers', 'TeacherController@student_answers');

	Route::get('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}/answer/{student_id?}', 'TeacherController@student_answer');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}/score_answer/{student_id?}', 'TeacherController@score_student_answer');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/publish_question/{lesson_id?}/score_answer/{student_id?}', 'TeacherController@save_score_student_answer');

	// lightbox dialogs
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/general_mode_time/{lesson_id?}', 'TeacherController@general_mode_time');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/general_mode_time/{lesson_id?}', 'TeacherController@save_general_mode_time');
	Route::get('subject/{alias?}/teaching_zone/{course_code?}/answer_mode_time/{lesson_id?}', 'TeacherController@answer_mode_time');
	Route::post('subject/{alias?}/teaching_zone/{course_code?}/answer_mode_time/{lesson_id?}', 'TeacherController@save_answer_mode_time');

	// Learning History
	Route::get('subject/{alias?}/learning_history', 'TeacherController@learning_history');
	Route::get('subject/{alias?}/learning_history/{course_code?}/student_list', 'TeacherController@lh_student_list');
	Route::get('subject/{alias?}/learning_history/{course_code?}/student_info/{student_id?}', 'TeacherController@lh_student_info');
	Route::get('subject/{alias?}/learning_history/{course_code?}/student_statistics', 'TeacherController@lh_student_statistics');

	// Test Bank
	Route::get('/test_bank', 'TeacherController@test_bank');
	Route::get('/test_bank/{subject?}', 'TeacherController@test_bank_list');
	Route::get('/test_bank/{subject?}/auto', 'TeacherController@test_bank_auto');
	Route::get('/test_bank/{subject?}/auto2', 'TeacherController@test_bank_auto2');
	Route::get('/test_bank/{subject?}/manual', 'TeacherController@test_bank_manual');
});