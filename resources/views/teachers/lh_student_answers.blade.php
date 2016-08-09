@extends('master_frame')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding:0px;">
					<table class="uk-table uk-table-hover">
						<thead>
							<tr>
								<th>帳號</th>
								<th>學號</th>
								<th>班級</th>
								<th>座號</th>
								<th>姓名</th>
								<th>答案</th>
								<th>得分</th>
								<th>手動給分</th>
								<th>狀態</th>
							</tr>
						</thead>
						<tbody>
							@forelse( $students as $i => $student )
							<?php
								$answer = DB::table('student_answers')
											->where('lesson_id', $lesson[0]->id)
											->where('student_id', $student->id)
											->get();
								// $student = DB::table('users')->where('id', $answer->student_id)->get();
							?>
							<tr>
								<td>a{{ ($student->id < 10 ? '00' : ($student->id < 100 ? '0' : '')).$student->id }}</td>
								<td>{{ date('yndhi', strtotime($student->created_at)) }}</td>
								<td>{{ $course[0]->course_name }}</td>
								<td>{{ $student->seat_no }}</td>
								<td><a target="_parent" href="{!! action('Teacher\TeacherController@lh_student_info', [$alias, $course[0]->course_code, $student->id]) !!}" class="showunderline">{{ $student->first_name.' '.$student->last_name }}</a></td>
								<td><?php
								$answer_txt = '';
								// wtf($answer);
								if( count($answer) ) {
									if( $lesson[0]->question_type == '單選題' ) {
										$answer_txt = DB::table('questions')->where('answer_code', $answer[0]->selected_answer)->value('answer');
										echo $answer_txt;
									} else {
										$answer_txt = $answer[0]->selected_answer;
										echo '<a href="'. action('Teacher\TeacherController@student_answer', [$alias, $course[0]->course_code, $lesson[0]->id, $student->id]) .'" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-file-photo-o"></i> 查看答案</a>';
									}
								}
								?></td>
								<td><?php
									$score = DB::table('student_scores')->where('student_id', $student->id)->where('lesson_id', $lesson[0]->id)->value('score');
									echo $score ? $score : 0;
								?></td>
								<td><?php
									echo '<a class="uk-button uk-button-primary" href="'. action('Teacher\TeacherController@score_student_answer', [$alias, $course[0]->course_code, $lesson[0]->id, $student->id]) .'" data-uk-lightbox="" data-lightbox-type="iframe">給分</a>';
								?></td>
								<td><span class="uk-text-muted"><?php
								if( count($answer) ) echo '已完成';
								else if( !count($answer) ) {
									if( strtotime($student->login_at) > strtotime($student->logout_at) ) {
										echo '未作答';
									} else {
										echo '離線';
									}
								}
								?></span></td>
							</tr>
							@empty
							@endforelse
						<tbody>
					</table>
				</div>
				<script>
				setInterval( function() {
					if( !$('.uk-modal').is(':visible') ) {
						location.reload();
					}
				}, 5000 );
				</script>
@endsection