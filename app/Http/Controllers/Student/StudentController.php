<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Requests\StudentAnswerRequest;
use App\Http\Controllers\Controller;

use DB;

use App\Subject;
use App\Lesson;
use App\Question;

class StudentController extends Controller
{
    public function index() {
		$subjects = Subject::all();
		return view('students.subjects', compact('subjects'));
	}
    public function dashboard( $alias ) {
		$nav = 'linfo';
		$subject = Subject::whereAlias($alias)->first();
		if( isset($subject->alias) ) {
			$student = DB::table('users')->where('id', Auth::user()->id)->get();
			$courses = DB::table('courses')->where('subject_id', $subject->id)->lists('id');
			$classes = DB::table('classes')
						->join('courses', 'courses.id', '=', 'classes.course_id')
						->join('users', 'users.id', '=', 'courses.teacher_id')
						->whereIn('classes.course_id', $courses)
						->where('classes.student_id', Auth::user()->id)
						->select('classes.course_id', 'courses.course_code', 'courses.course_name', 'users.id', 'users.first_name', 'users.last_name')
						->get();
			// wtf($classes);die();
			return view('students.learning_info', compact('alias', 'nav', 'subject', 'student', 'classes'));
		} else {
			return redirect( 'student/subject' );
		}
	}
    public function add_course( Request $request, $alias ) {
		$course = DB::table('courses')->where('course_code', $request->get('course_code'))->get();
		if( count($course) ) {
			$check = DB::table('classes')->where('course_id', $course[0]->id)->where('student_id', Auth::user()->id)->get();
			if( count($check) ) {
				return back()->with('status', 'You have already joined this course!');
			} else {
				DB::table('classes')->insert([
					'student_id'	=> Auth::user()->id,
					'course_id'		=> $course[0]->id
				]);
				return back()->with('status', 'You have joined this course successfully!');
			}
		} else {
			return back()->with('error', 'Invalid course code!');
		}
	}
    public function lesson_scores( $alias, $course_code ) {
		$nav = 'lrecord';
		$subject = Subject::whereAlias($alias)->first();
		$student = DB::table('users')->where('id', Auth::user()->id)->get();
		$courses = DB::table('courses')->where('subject_id', $subject->id)->lists('id');
		$classes = DB::table('classes')
					->join('courses', 'courses.id', '=', 'classes.course_id')
					->join('users', 'users.id', '=', 'courses.teacher_id')
					->whereIn('classes.course_id', $courses)
					->where('classes.student_id', Auth::user()->id)
					->select('classes.course_id', 'courses.course_code', 'courses.course_name', 'users.id', 'users.first_name', 'users.last_name')
					->get();

		// individual lessons
		$subject = Subject::whereAlias($alias)->first();
		$courses = DB::table('courses')->where('subject_id', $subject->id)->lists('id');
		// $lessons_n_scores = DB::table('student_scores')
							// ->join('courses', 'student_scores.course_id', '=', 'courses.id')
							// ->join('lessons', 'student_scores.lesson_id', '=', 'lessons.id')
							// ->whereIn('student_scores.course_id', $courses)
							// ->where('student_scores.student_id', Auth::user()->id)
							// ->select('student_scores.*', 'courses.course_name', 'courses.course_code', 'lessons.topic_name')
							// ->get();
			$lessons = DB::table('lessons')
						->join('courses', 'courses.id', '=', 'lessons.course_id')
						->join('classes', 'courses.id', '=', 'classes.course_id')
						->join('users', 'users.id', '=', 'lessons.teacher_id')
						->where('courses.course_code', $course_code)
						->where('classes.student_id', Auth::user()->id)
						->select('lessons.*', 'courses.course_code', 'courses.course_name', 'users.first_name', 'users.last_name')
						->get();
			// wtf($lessons);die();
		return view('students.lesson_scores', compact('alias', 'nav', 'course_code', 'subject', 'lessons', 'classes'));
	}
    public function lesson_concept( $alias, $course_code, $id ) {
		$nav = 'lrecord';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $id)->get();
		return view('students.lesson_concept', compact('course', 'lesson', 'alias', 'nav'));
	}
    public function lesson_question( $alias, $course_code, $id ) {
		$nav = 'lrecord';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $id)->get();
		$answers = DB::table('questions')->where('lesson_id', $id)->get();
		$selected_answer = DB::table('student_answers')->where('lesson_id', $id)->where('student_id', Auth::user()->id)->get();
		return view('students.lesson_question', compact('course', 'lesson', 'answers', 'selected_answer', 'alias', 'nav'));
	}
    public function store_answer( StudentAnswerRequest $request, $alias, $course_code, $id ) {
		// wtf( $request->all() );die();

		$attached_img = '';
		if ($request->hasFile('answer_file')) {
			$img_file = $request->file('answer_file');
			if($img_file->isValid()) {
				$destinationPath = 'uploads/sanswers';
				$extension = $img_file->getClientOriginalExtension();
				$attached_img = time().'_'.rand(11111,99999).'.'.$extension;
				$img_file->move($destinationPath, $attached_img);
			}
		}

		$now = date('Y-m-d H:i:s');
		DB::table('student_answers')->insert([
			'student_id'		=> Auth::user()->id,
			'lesson_id'			=> $id,
			'selected_answer'	=> $request->get('selected_answer'),
			'answer_file'		=> $attached_img,
			'answered_at'		=> $now
		]);

		// auto scoring
		$lesson = DB::table('lessons')->where('id', $id)->get();
		$course = DB::table('courses')->where('course_code', $course_code)->get();
		if( $lesson[0]->question_type == '單選題' ) {
			$answers = DB::table('questions')->where('lesson_id', $id)->where('correct', '!=', '')->value('correct');
			if( $answers == $request->get('selected_answer') ) {
				DB::table('student_scores')->insert([
					'student_id'		=> Auth::user()->id,
					'lesson_id'			=> $id,
					'course_id'			=> $course[0]->id,
					'score'				=> $lesson[0]->score,
					'created_at'		=> $now,
					'updated_at'		=> $now,
				]);
			}
			
		}

		return back()->with('status', 'Answered stored successfully!');
	}
}
