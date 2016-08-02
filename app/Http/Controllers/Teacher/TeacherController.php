<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;
use App\Http\Requests\CourseFormRequest;
use App\Http\Requests\LessonFormRequest;
use App\Http\Controllers\Controller;

use DB;

use App\Subject;
use App\Lesson;
use App\Question;

class TeacherController extends Controller
{
    public function index() {
		$subjects = Subject::all();
		return view('teachers.subjects', compact('subjects'));
	}
    public function dashboard($alias) {
		$subject = Subject::whereAlias($alias)->first();
		if( isset($subject->alias) ) {
			return view('teachers.index', compact('alias', 'subject'));
		} else {
			return redirect( 'teacher/subject' );
		}
	}

    // courses
    public function course_list( $alias ) {
		$selected_nav = 'lesson_list';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$courses = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('subject_id', $subject_id)->paginate(10);
		return view('teachers.course_list', compact('courses', 'alias', 'selected_nav'));
	}
    public function course_edit( $alias, $id ) {
		$selected_nav = 'lesson_list';
		$course = DB::table('courses')->where('id', $id)->get();
		return view('teachers.course_edit', compact('course', 'answers', 'alias', 'selected_nav'));
	}
    public function course_delete( $alias, $id ) {
		$selected_nav = 'lesson_list';
		$course = DB::table('courses')->where('id', $id)->get();

		$lessons = DB::table('lessons')->where('course_id', $id)->update([ 'course_id' => 0 ]);
		/*if( count($lessons) ) {
			foreach( $lessons as $lesson ) {
				// delete answers if any
				DB::table('questions')->where('lesson_id', $lesson->id)->delete();

				// delete lesson attached files
				if( $lesson->attached_doc ) {
					if( file_exists('uploads/docs/'.$lesson->attached_doc) ) {
						unlink('uploads/docs/'.$lesson->attached_doc);
					}
				}
				if( $lesson->attached_pdf ) {
					if( file_exists('uploads/pdfs/'.$lesson->attached_pdf) ) {
						unlink('uploads/pdfs/'.$lesson->attached_pdf);
					}
				}

				// delete lesson data
				DB::table('lessons')->where('id', $lesson->id)->delete();
			}
		}*/

		// delete course attached files
		if( $course[0]->attached_doc ) {
			if( file_exists('uploads/docs/'.$course[0]->attached_doc) ) {
				unlink('uploads/docs/'.$course[0]->attached_doc);
			}
		}
		if( $course[0]->attached_pdf ) {
			if( file_exists('uploads/pdfs/'.$course[0]->attached_pdf) ) {
				unlink('uploads/pdfs/'.$course[0]->attached_pdf);
			}
		}

		// delete course data
		DB::table('courses')->where('id', $course[0]->id)->delete();

		return back()->with('status', 'Course deleted successfully!');
	}
    public function course_create(CourseFormRequest $request, $alias) {
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		if( !$subject_id ) {
			return back()->with('error', 'Subject ID missing!');
		}

		$lesson_ids = $request->get('lesson_ids');
		if( !count($lesson_ids) ) {
			return back()->with('error', 'Please select lessons to assign!');
		}
		// wtf( $request->all() );die();

		/*$attached_doc = $attached_pdf = '';

		if ($request->hasFile('attached_doc')) {
			$doc_file = $request->file('attached_doc');
			if($doc_file->isValid()) {
				$destinationPath = 'uploads/docs';
				$extension = $doc_file->getClientOriginalExtension();
				$attached_doc = 'C_'.time().'_'.rand(11111,99999).'.'.$extension;
				$doc_file->move($destinationPath, $attached_doc);
			}
		}

		if ($request->hasFile('attached_pdf')) {
			$pdf_file = $request->file('attached_pdf');
			if($pdf_file->isValid()) {
				$destinationPath = 'uploads/pdfs';
				$extension = $pdf_file->getClientOriginalExtension();
				$attached_pdf = 'C_'.time().'_'.rand(11111,99999).'.'.$extension;
				$pdf_file->move($destinationPath, $attached_pdf);
			}
		}*/

		$check = DB::table('courses')->where('subject_id', $subject_id)->where('course_name', trim($request->get('course_name')))->value('id');
		if( $check ) {
			$course_id = $check;
		} else {
			$now = date('Y-m-d H:i:s');
			$course_code = get_course_code( $request->get('course_name') );

			$course_id = DB::table('courses')->insertGetId([
				'teacher_id'	=> Auth::user()->id,
				'subject_id'	=> $subject_id,
				// 'category'		=> $request->get('category'),
				'course_code'	=> $course_code,
				'course_name'	=> $request->get('course_name'),
				// 'description'	=> $request->get('description'),
				// 'video_embed'	=> $request->get('video_embed'),
				// 'attached_doc'	=> $attached_doc,
				// 'attached_pdf'	=> $attached_pdf,
				'created_at'	=> $now,
				'updated_at'	=> $now,
			]);
		}

		// assign lessons to course
		DB::table('lessons')->whereIN('id', $lesson_ids)->update(['course_id' => $course_id]);

		Session::flash('tab', 'list');
		return back()->with('status', 'Course assigned successfully!');
	}
    public function course_update(CourseFormRequest $request, $alias, $id) {
		$attached_doc = $attached_pdf = '';

		$lesson = DB::table('courses')->where('id', $id)->get();

		if ($request->hasFile('attached_doc')) {
			$doc_file = $request->file('attached_doc');
			if($doc_file->isValid()) {
				$destinationPath = 'uploads/docs';
				$extension = $doc_file->getClientOriginalExtension();
				$attached_doc = 'C_'.time().'_'.rand(11111,99999).'.'.$extension;
				$doc_file->move($destinationPath, $attached_doc);

				// unlink previous file if any
				if( $lesson[0]->attached_doc ) {
					if( file_exists($destinationPath.'/'.$lesson[0]->attached_doc) ) {
						unlink($destinationPath.'/'.$lesson[0]->attached_doc);
					}
				}
			}
		} else {
			$attached_doc = $lesson[0]->attached_doc;
		}

		if ($request->hasFile('attached_pdf')) {
			$pdf_file = $request->file('attached_pdf');
			if($pdf_file->isValid()) {
				$destinationPath = 'uploads/pdfs';
				$extension = $pdf_file->getClientOriginalExtension();
				$attached_pdf = 'C_'.time().'_'.rand(11111,99999).'.'.$extension;
				$pdf_file->move($destinationPath, $attached_pdf);

				// unlink previous file if any
				if( $lesson[0]->attached_pdf ) {
					if( file_exists($destinationPath.'/'.$lesson[0]->attached_pdf) ) {
						unlink($destinationPath.'/'.$lesson[0]->attached_pdf);
					}
				}
			}
		} else {
			$attached_pdf = $lesson[0]->attached_pdf;
		}

		$now = date('Y-m-d H:i:s');
		$lesson_id = DB::table('courses')->where('id', $id)->update([
			'category'		=> $request->get('category'),
			'course_name'	=> $request->get('course_name'),
			'description'	=> $request->get('description'),
			'video_embed'	=> $request->get('video_embed'),
			'attached_doc'	=> $attached_doc,
			'attached_pdf'	=> $attached_pdf,
			'updated_at'	=> $now,
		]);

		return back()->with('status', 'Course updated successfully!');
	}
	public function student_list( $alias, $course_code ) {
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$students = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 1)
					->lists('users.id');
		shuffle( $students );	// get random list for now
		$student_list = DB::table('users')->whereIn('id', array_slice($students, 6))->get();

		return view('teachers.student_list', compact('course', 'alias', 'student_list'));
	}

    // lessons
	public function lesson_list( $alias/*, $course_id*/ ) {
		$selected_nav = 'lesson_list';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		// $course = DB::table('courses')->where('id', $course_id)->get();
		$lessons = DB::table('lessons')->where('subject_id', $subject_id)->paginate(10);
		return view('teachers.lesson_list', compact('lessons', 'alias', 'selected_nav'));
	}
    public function lesson_details( $alias/*, $course_id*/, $id ) {
		$selected_nav = 'lesson_list';
		$lesson = DB::table('lessons')->where('id', $id)->get();
		$answers = DB::table('questions')->where('lesson_id', $id)->get();
		return view('teachers.lesson_details', compact('lesson', 'answers', 'alias'/*, 'course_id'*/, 'selected_nav'));
	}
    public function lesson_edit( $alias/*, $course_id*/, $id ) {
		$selected_nav = 'lesson_list';
		$lesson = DB::table('lessons')->where('id', $id)->get();
		$answers = DB::table('questions')->where('lesson_id', $id)->get();
		return view('teachers.lesson_edit', compact('lesson', 'answers', 'alias'/*, 'course_id'*/, 'selected_nav'));
	}
    public function lesson_delete( $alias/*, $course_id*/, $id ) {
		$lesson = DB::table('lessons')->where('id', $id)->get();

		// delete answers if any
		DB::table('questions')->where('lesson_id', $id)->delete();

		// delete attached files
		if( $lesson[0]->attached_doc ) {
			if( file_exists('uploads/docs/'.$lesson[0]->attached_doc) ) {
				unlink('uploads/docs/'.$lesson[0]->attached_doc);
			}
		}
		if( $lesson[0]->attached_pdf ) {
			if( file_exists('uploads/pdfs/'.$lesson[0]->attached_pdf) ) {
				unlink('uploads/pdfs/'.$lesson[0]->attached_pdf);
			}
		}

		// delete lesson data
		DB::table('lessons')->where('id', $id)->delete();

		return back()->with('status', 'Lesson deleted successfully!');
	}
    public function lesson_create(LessonFormRequest $request, $alias/*, $course_id*/) {
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		if( !$subject_id ) {
			return back()->with('error', 'Subject ID missing!');
		}

		$attached_doc = $attached_pdf = '';

		if ($request->hasFile('attached_doc')) {
			$doc_file = $request->file('attached_doc');
			if($doc_file->isValid()) {
				$destinationPath = 'uploads/docs';
				$extension = $doc_file->getClientOriginalExtension();
				$attached_doc = time().'_'.rand(11111,99999).'.'.$extension;
				$doc_file->move($destinationPath, $attached_doc);
			}
		}

		if ($request->hasFile('attached_pdf')) {
			$pdf_file = $request->file('attached_pdf');
			if($pdf_file->isValid()) {
				$destinationPath = 'uploads/pdfs';
				$extension = $pdf_file->getClientOriginalExtension();
				$attached_pdf = time().'_'.rand(11111,99999).'.'.$extension;
				$pdf_file->move($destinationPath, $attached_pdf);
			}
		}

		$now = date('Y-m-d H:i:s');

		$lesson_closing_time = array(
			'days'		=> 0,
			'hours'		=> 0,
			'minutes'	=> 50,
		);

		$lesson_id = DB::table('lessons')->insertGetId([
			'teacher_id'	=> Auth::user()->id,
			'subject_id'	=> $subject_id,
			'course_id'		=> 0,
			'category'		=> $request->get('category'),
			'topic_name'	=> $request->get('topic_name'),
			'description'	=> $request->get('description'),
			'video_embed'	=> $request->get('video_embed'),
			'lesson_closing_time'	=> json_encode($lesson_closing_time),
			'question_type'	=> $request->get('question_type'),
			'attached_doc'	=> $attached_doc,
			'attached_pdf'	=> $attached_pdf,
			'created_at'	=> $now,
			'updated_at'	=> $now,

		]);

		if( $request->get('category') == '練習' ) {
			switch( $request->get('question_type') ) {
				case '單選題':
					$mc_answers = $request->get('mc_answer');
					if( count($mc_answers) ) {
						foreach( $mc_answers as $i => $answer ) {
							$answer_code = get_answer_code( $answer );
							DB::table('questions')->insert([
								'lesson_id'	=> $lesson_id,
								'answer'	=> $answer,
								'answer_code'	=> $answer_code,
								'correct'	=> $request->get('correct') == $i ? $answer_code : '',
								'created_at'=> $now,
								'updated_at'=> $now,
							]);
						}
					}
					break;
				case '填充題':
					DB::table('questions')->insert([
						'lesson_id'	=> $lesson_id,
						'answer'	=> $request->get('fill_in_answer'),
						'created_at'=> $now,
						'updated_at'=> $now,
					]);
					break;
				case '問答題':
					DB::table('questions')->insert([
						'lesson_id'	=> $lesson_id,
						'answer'	=> $request->get('qna_answer'),
						'created_at'=> $now,
						'updated_at'=> $now,
					]);
					break;
			}
		}

		return back()->with('status', 'Lesson created successfully!');
	}
    public function lesson_update(LessonFormRequest $request, $alias/*, $course_id*/, $id) {
		$attached_doc = $attached_pdf = '';

		$lesson = DB::table('lessons')->where('id', $id)->get();

		if ($request->hasFile('attached_doc')) {
			$doc_file = $request->file('attached_doc');
			if($doc_file->isValid()) {
				$destinationPath = 'uploads/docs';
				$extension = $doc_file->getClientOriginalExtension();
				$attached_doc = time().'_'.rand(11111,99999).'.'.$extension;
				$doc_file->move($destinationPath, $attached_doc);

				// unlink previous file if any
				if( $lesson[0]->attached_doc ) {
					if( file_exists($destinationPath.'/'.$lesson[0]->attached_doc) ) {
						unlink($destinationPath.'/'.$lesson[0]->attached_doc);
					}
				}
			}
		} else {
			$attached_doc = $lesson[0]->attached_doc;
		}

		if ($request->hasFile('attached_pdf')) {
			$pdf_file = $request->file('attached_pdf');
			if($pdf_file->isValid()) {
				$destinationPath = 'uploads/pdfs';
				$extension = $pdf_file->getClientOriginalExtension();
				$attached_pdf = time().'_'.rand(11111,99999).'.'.$extension;
				$pdf_file->move($destinationPath, $attached_pdf);

				// unlink previous file if any
				if( $lesson[0]->attached_pdf ) {
					if( file_exists($destinationPath.'/'.$lesson[0]->attached_pdf) ) {
						unlink($destinationPath.'/'.$lesson[0]->attached_pdf);
					}
				}
			}
		} else {
			$attached_pdf = $lesson[0]->attached_pdf;
		}
		// wtf($request->all());

		$now = date('Y-m-d H:i:s');
		$lesson_id = DB::table('lessons')->where('id', $id)->update([
			'category'		=> $request->get('category'),
			'topic_name'	=> $request->get('topic_name'),
			'description'	=> $request->get('description'),
			'video_embed'	=> $request->get('video_embed'),
			'question_type'	=> $request->get('question_type'),
			'attached_doc'	=> $attached_doc,
			'attached_pdf'	=> $attached_pdf,
			'updated_at'	=> $now,
		]);

		if( $request->get('category') == '練習' ) {
			//delete existing answers if any and insert new ones
			DB::table('questions')->where('lesson_id', $id)->delete();

			switch( $request->get('question_type') ) {
				case '單選題':
					$mc_answers = $request->get('mc_answer');
					if( count($mc_answers) ) {
						foreach( $mc_answers as $i => $answer ) {
							$answer_code = get_answer_code( $answer );
							DB::table('questions')->insert([
								'lesson_id'	=> $id,
								'answer'	=> $answer,
								'answer_code'	=> $answer_code,
								'correct'	=> $request->get('correct') == $i ? $answer_code : '',
								'created_at'=> $now,
								'updated_at'=> $now,
							]);
						}
					}
					break;
				case '填充題':
					DB::table('questions')->insert([
						'lesson_id'	=> $id,
						'answer'	=> $request->get('fill_in_answer'),
						'created_at'=> $now,
						'updated_at'=> $now,
					]);
					break;
				case '問答題':
					DB::table('questions')->insert([
						'lesson_id'	=> $id,
						'answer'	=> $request->get('qna_answer'),
						'created_at'=> $now,
						'updated_at'=> $now,
					]);
					break;
			}
		}

		return back()->with('status', 'Lesson updated successfully!');
	}

    // Teaching Zone
	public function teaching_zone( $alias ) {
		$selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$courses = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('subject_id', $subject_id)->paginate(10);
		return view('teachers.lesson_teaching', compact('courses', 'alias', 'selected_nav'));
	}
	public function copy_course( $alias, $course_code ) {
		// $selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		// $lessons = DB::table('lessons')->where('course_id', $course[0]->id)->get();
		return view('teachers.copy_course', compact('course'));
	}
	public function copyncreate_course( Request $request, $alias, $course_code ) {
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lessons = DB::table('lessons')->where('course_id', $course[0]->id)->get();

		$new_attached_doc = $new_attached_pdf = '';
		if ( $course[0]->attached_doc ) {
			$destinationPath = 'uploads/docs/';
			$doc_file = $course[0]->attached_doc;
			$ext = pathinfo($destinationPath.$course[0]->attached_doc, PATHINFO_EXTENSION);

			$new_attached_doc = 'C_'.time().'_'.rand(11111,99999).'.'.$ext;
			File::copy($destinationPath.$doc_file, $destinationPath.$new_attached_doc);
		}

		if ( $course[0]->attached_pdf ) {
			$destinationPath = 'uploads/pdfs/';
			$pdf_file = $course[0]->attached_pdf;
			$ext = pathinfo($destinationPath.$course[0]->attached_pdf, PATHINFO_EXTENSION);

			$new_attached_pdf = 'C_'.time().'_'.rand(11111,99999).'.'.$ext;
			File::copy($destinationPath.$pdf_file, $destinationPath.$new_attached_pdf);
		}

		$now = date('Y-m-d H:i:s');
		$course_code = get_course_code( $request->get('course_name') );
		$new_course_id = DB::table('courses')->insertGetId([
			'teacher_id'	=> Auth::user()->id,
			'subject_id'	=> $subject_id,
			'category'		=> $course[0]->category,
			'course_code'	=> $course_code,
			'course_name'	=> $request->get('course_name'),
			'description'	=> $course[0]->description,
			'video_embed'	=> $course[0]->video_embed,
			'attached_doc'	=> $new_attached_doc,
			'attached_pdf'	=> $new_attached_pdf,
			'created_at'	=> $now,
			'updated_at'	=> $now,
		]);

		if( count($lessons) ) {
			foreach( $lessons as $lesson ) {
				$new_attached_doc = $new_attached_pdf = '';
				if ( $lesson->attached_doc ) {
					$destinationPath = 'uploads/docs/';
					$doc_file = $lesson->attached_doc;
					$ext = pathinfo($destinationPath.$lesson->attached_doc, PATHINFO_EXTENSION);

					$new_attached_doc = time().'_'.rand(11111,99999).'.'.$ext;
					File::copy($destinationPath.$doc_file, $destinationPath.$new_attached_doc);
				}

				if ( $lesson->attached_pdf ) {
					$destinationPath = 'uploads/pdfs/';
					$pdf_file = $lesson->attached_pdf;
					$ext = pathinfo($destinationPath.$lesson->attached_pdf, PATHINFO_EXTENSION);

					$new_attached_pdf = time().'_'.rand(11111,99999).'.'.$ext;
					File::copy($destinationPath.$pdf_file, $destinationPath.$new_attached_pdf);
				}

				$lesson_id = DB::table('lessons')->insertGetId([
					'course_id'		=> $new_course_id,
					'category'		=> $lesson->category,
					'topic_name'	=> $lesson->topic_name,
					'description'	=> $lesson->description,
					'video_embed'	=> $lesson->video_embed,
					'lesson_closing_time'	=> $lesson->lesson_closing_time,
					'question_type'	=> $lesson->question_type,
					'attached_doc'	=> $new_attached_doc,
					'attached_pdf'	=> $new_attached_pdf,
					'created_at'	=> $now,
					'updated_at'	=> $now,

				]);
			}
		}

		return back()->with('status', 'Course copied successfully!');
	}
	public function share_course( $alias, $course_code ) {
		// $selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		// $lessons = DB::table('lessons')->where('course_id', $course[0]->id)->get();

		$shared_with = DB::table('courses_shared')->where('course_id', $course[0]->id)->lists('teacher_id');

		$teachers = DB::table('users')
					->join('role_user', 'users.id', '=', 'role_user.user_id')
					->where('role_user.role_id', 2)
					->where('role_user.user_id', '!=', Auth::user()->id)
					->whereNotIn('role_user.user_id', $shared_with)
					->select('users.id', 'users.first_name', 'users.last_name')->get();
		$shared_teachers = DB::table('users')
							->whereIn('id', $shared_with)
							->select('users.id', 'users.first_name', 'users.last_name')->get();
		return view('teachers.share_course', compact('alias', 'course', 'teachers', 'shared_teachers'));
	}
	public function set_shared_course( Request $request, $alias, $course_code ) {
		wtf( $request->get('share_with') );
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();

		$teacher_id = $request->get('share_with');
		DB::table('courses_shared')->insert([
			'course_id'	=> $course[0]->id,
			'teacher_id'=> $teacher_id
		]);

		return back()->with('status', 'Course shared successfully!');
	}
	public function del_shared_course( $alias, $course_code, $teacher_id ) {
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();

		DB::table('courses_shared')
		->where('course_id', $course[0]->id)
		->where('teacher_id', $teacher_id)
		->delete();

		return back()->with('status', 'Course share removed!');
	}
	public function lesson_list_content( $alias, $course_code ) {
		$requested_course_code = Input::get('course_code');
		if( $requested_course_code ) {
			return redirect('teacher/subject/' .$alias. '/teaching_zone/'.$requested_course_code);
		}

		$selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lessons = DB::table('lessons')->where('course_id', $course[0]->id)->get();
		return view('teachers.lesson_list_content', compact('course', 'lessons', 'alias', 'selected_nav'));
	}
	public function lesson_list_content_store( Request $request, $alias, $course_code ) {
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->get();
		$lessons = DB::table('lessons')->where('course_id', $course[0]->id)->count();
		for( $i = 0; $i < $lessons; $i++ ) {
			$lesson_id	= $request->get('lid_'.$i);
			$sequence	= $request->get('sequence_'.$i);
			$score		= $request->get('score_'.$i);

			DB::table('lessons')->where('id', $lesson_id)->update([
				'sequence'	=> $sequence,
				'score'		=> $score,
			]);
		}
		return back()->with('status', 'Lessons updated successfully!');
	}
	public function class_begins( $alias, $course_code ) {
		$selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lessons = DB::table('lessons')->where('course_id', $course[0]->id)->orderBy('sequence', 'asc')->get();
		return view('teachers.class_begins', compact('course', 'lessons', 'alias', 'selected_nav'));
	}
	public function publish_concept( $alias, $course_code, $lesson_id ) {
		$selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $lesson_id)->get();
		return view('teachers.publish_concept', compact('course', 'lesson', 'alias', 'selected_nav'));
	}
	public function publish_question( $alias, $course_code, $lesson_id ) {
		$selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $lesson_id)->get();
		return view('teachers.publish_question', compact('course', 'lesson', 'alias', 'selected_nav'));
	}
	public function student_answer( $alias, $course_code, $lesson_id, $student_id ) {
		// $selected_nav = 'teaching_zone';
		$answer = DB::table('student_answers')->where('lesson_id', $lesson_id)->where('student_id', $student_id)->get();
		return view('teachers.lh_student_answer', compact('answer', 'alias'));
	}
	public function score_student_answer( $alias, $course_code, $lesson_id, $student_id ) {
		// $selected_nav = 'teaching_zone';
		$lesson = DB::table('lessons')->where('id', $lesson_id)->get();
		$answer = DB::table('student_answers')->where('lesson_id', $lesson_id)->where('student_id', $student_id)->get();
		$score_received = DB::table('student_scores')->where('lesson_id', $lesson_id)->where('student_id', $student_id)->get();
		return view('teachers.lh_score_student_answer', compact('answer', 'lesson', 'score_received', 'alias'));
	}
	public function save_score_student_answer( Request $request, $alias, $course_code, $lesson_id, $student_id ) {
		// $selected_nav = 'teaching_zone';
		$course = DB::table('courses')->where('course_code', $course_code)->get();

		$now = date('Y-m-d H:i:s');
		$score_received = DB::table('student_scores')->where('lesson_id', $lesson_id)->where('student_id', $student_id)->get();
		if( count($score_received) ) {
			DB::table('student_scores')
			->where('student_id', $student_id)
			->where('lesson_id', $lesson_id)
			->where('course_id', $course[0]->id)
			->update([
				'score'		=> $request->get('score'),
				'updated_at'=> $now
			]);
		} else {
			DB::table('student_scores')
			->insert([
				'student_id'=> $student_id,
				'lesson_id'	=> $lesson_id,
				'course_id'	=> $course[0]->id,
				'score'		=> $request->get('score'),
				'created_at'=> $now,
				'updated_at'=> $now
			]);
		}
		return back()->with('status', 'Score saved successfully!');
	}
	public function general_mode_time( $alias, $course_code, $lesson_id ) {
		// $selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $lesson_id)->get();
		return view('teachers.general_mode_time', compact('course', 'lesson', 'alias'));
	}
	public function save_general_mode_time( Request $request, $alias, $course_code, $lesson_id ) {
		// $selected_nav = 'teaching_zone';
		$data = array(
			'mins'	=> $request->get('mins'),
			'secs'	=> $request->get('secs')
		);
		DB::table('lessons')->where('id', $lesson_id)->update([
			'general_mode_time'	=> json_encode($data)
		]);
		return back()->with('status', 'Update successful!');
	}
	public function answer_mode_time( $alias, $course_code, $lesson_id ) {
		// $selected_nav = 'teaching_zone';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$lesson = DB::table('lessons')->where('course_id', $course[0]->id)->where('id', $lesson_id)->get();
		return view('teachers.answer_mode_time', compact('course', 'lesson', 'alias'));
	}
	public function save_answer_mode_time( Request $request, $alias, $course_code, $lesson_id ) {
		// $selected_nav = 'teaching_zone';
		$data = array(
			'mins'	=> $request->get('mins'),
			'secs'	=> $request->get('secs')
		);
		DB::table('lessons')->where('id', $lesson_id)->update([
			'answer_mode_time'	=> json_encode($data)
		]);
		return back()->with('status', 'Update successful!');
	}
	public function save_closing_time( Request $request, $alias, $course_code, $lesson_id ) {
		// $selected_nav = 'teaching_zone';
		$tdata = array(
			'days'		=> $request->get('days'),
			'hours'		=> $request->get('hour'),
			'minutes'	=> $request->get('mins')
		);
		DB::table('lessons')->where('id', $lesson_id)->update([
			'lesson_closing_time'	=> json_encode($tdata)
		]);
		return back()->with('status', 'Update successful!');
	}

	// Learning History
	public function learning_history( $alias ) {
		$selected_nav = 'learning_history';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$courses = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('subject_id', $subject_id)->paginate(10);
		return view('teachers.learning_history', compact('alias', 'courses', 'selected_nav'));
	}
	public function lh_student_list( $alias, $course_code ) {
		$selected_nav = 'learning_history';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		$students = DB::table('classes')
					->where('course_id', $course[0]->id)
					->lists('student_id');
		$student_list = DB::table('users')->whereIn('id', $students)->get();

		return view('teachers.lh_student_list', compact('course', 'alias', 'student_list', 'selected_nav'));
	}
	public function lh_student_info( $alias, $course_code, $student_id ) {
		$selected_nav = 'learning_history';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$student = DB::table('users')->where('id', $student_id)->get();
		$courses = DB::table('courses')->where('subject_id', $subject_id)->lists('id');
		$classes = DB::table('classes')
					->join('courses', 'courses.id', '=', 'classes.course_id')
					->join('users', 'users.id', '=', 'courses.teacher_id')
					->whereIn('classes.course_id', $courses)
					->where('classes.student_id', $student_id)
					->select('classes.course_id', 'courses.course_code', 'courses.course_name', 'users.id', 'users.first_name', 'users.last_name')
					->get();

		return view('teachers.lh_student_info', compact('student', 'courses', 'classes', 'alias', 'selected_nav'));
	}
	public function lh_student_statistics( $alias, $course_code ) {
		$selected_nav = 'learning_history';
		$subject_id = $alias ? DB::table('subjects')->where('alias', $alias)->value('id') : 0;
		$course = DB::table('courses')->where('teacher_id', Auth::user()->id)->where('course_code', $course_code)->where('subject_id', $subject_id)->get();
		return view('teachers.lh_student_statistics', compact('alias', 'course', 'selected_nav'));
	}

	// Test Bank
	public function test_bank() {
		$subjects = array_unique( DB::table('lessons')->lists('subject_id') );
		$subject_list = DB::table('subjects')->whereIn( 'id', $subjects )->get();
		$selected_nav = 'test_bank';
		return view('teachers.test_bank', compact('selected_nav', 'subject_list'));
	}
	public function test_bank_list( $subject ) {
		$selected_nav = 'test_bank';
		return view('teachers.test_bank_list', compact('selected_nav', 'subject'));
	}
	public function test_bank_auto( $subject ) {
		$selected_nav = 'test_bank';
		return view('teachers.test_bank_auto', compact('selected_nav', 'subject'));
	}
	public function test_bank_auto2( $subject ) {
		$selected_nav = 'test_bank';
		return view('teachers.test_bank_auto2', compact('selected_nav', 'subject'));
	}
	public function test_bank_manual( $subject ) {
		$selected_nav = 'test_bank';
		return view('teachers.test_bank_manual', compact('selected_nav', 'subject'));
	}
}
