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
								<th>票數</th>
							</tr>
						</thead>
						<tbody>
							@foreach( $selected_for_vote as $answer )
							<?php
							$answer = DB::table('student_answers')
										->where('id', $answer->answer_id)
										->get();
							$votes = DB::table('student_votes')
										->where('answer_id', $answer[0]->id)
										->value('votes');
							$student = DB::table('users')
										->join('classes', 'classes.student_id', '=', 'users.id')
										->where('users.id', $answer[0]->student_id)
										->get();
							?>
							<tr>
								<td>a{{ ($student[0]->id < 10 ? '00' : ($student[0]->id < 100 ? '0' : '')).$student[0]->id }}</td>
								<td>{{ date('yndhi', strtotime($student[0]->created_at)) }}</td>
								<td>{{ $course[0]->course_name }}</td>
								<td>{{ $student[0]->seat_no }}</td>
								<td><a target="_parent" href="{!! action('Teacher\TeacherController@lh_student_info', [$alias, $course[0]->course_code, $student[0]->id]) !!}" class="showunderline">{{ $student[0]->first_name.' '.$student[0]->last_name }}</a></td>
								<td><?php
									$answer_txt = '';
									// wtf($answer);
									if( count($answer) ) {
										if( $lesson[0]->question_type == '單選題' ) {
											$answer_txt = DB::table('questions')->where('answer_code', $answer[0]->selected_answer)->value('answer');
											echo $answer_txt;
										} else {
											$answer_txt = $answer[0]->selected_answer;
											echo '<a href="'. action('Teacher\TeacherController@student_answer', [$alias, $course[0]->course_code, $lesson[0]->id, $student[0]->id]) .'" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-file-photo-o"></i> 查看答案</a>';
										}
									}
								?></td>
								<td><span class="uk-text-danger uk-text-large">{{ $votes }}</span></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<script>
				var h = $( document ).height();
				setInterval( function() {
					location.reload();
				}, 10000 );
				parent.setHeight('ifvotes', h);
				</script>
@endsection