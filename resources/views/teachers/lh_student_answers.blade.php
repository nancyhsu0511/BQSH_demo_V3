@extends('master_frame')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding:0px;">
					<form method="post" id="select_for_voting">
						<table class="uk-table uk-table-hover">
							<thead>
								<tr>
									@if( $lesson[0]->question_type != '單選題' )
									<th>選擇</th>
									@endif
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
									$selected_for_vote = DB::table('student_votes')
													->where('lesson_id', $lesson[0]->id)
													->lists('answer_id');
									// $student = DB::table('users')->where('id', $answer->student_id)->get();
								?>
								<tr>
									@if( $lesson[0]->question_type != '單選題' && count($answer) )
										@if( in_array($answer[0]->id, $selected_for_vote) )
										<td><i class="uk-icon-check"></i></td>
										@else
										<td><input type="checkbox" class="answer_select" name="selected_answers[]" value="{{ $answer[0]->id }}" /></td>
										@endif
									@else
									<td>-</td>
									@endif
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
									if( count($answer) ) echo '<span class="uk-text-muted">已完成</span>';
									else if( !count($answer) ) {
										if( strtotime($student->login_at) > strtotime($student->logout_at) ) {
											echo '<span class="uk-text-warning">未作答</span>';
										} else {
											echo '<span class="uk-text-danger">離線</span>';
										}
									}
									?></span></td>
								</tr>
								@empty
								@endforelse
							<tbody>
						</table>
						@if( $lesson[0]->question_type != '單選題' )
						<div class="uk-form-row">
							<div class="uk-form-controls">
								<button type="button" class="uk-button uk-button-danger submit_for_vote">分享作答</button>
							</div>
						</div>
						@endif
						{!! csrf_field() !!}
					</form>
				</div>
				<script>
				var h = $( document ).height();
				var check_selected = function() {
					var atLeastOneIsChecked = false;
					$('.answer_select').each(function () {
						if ($(this).is(':checked')) {
							atLeastOneIsChecked = true;
							return atLeastOneIsChecked;
						}
					});
					return atLeastOneIsChecked;
				};
				$('.submit_for_vote').click(function() {
					if( check_selected() ) { $('#select_for_voting').submit(); }
					else { alert('Please select answers to vote!'); }
				});
				setInterval( function() {
					if( !$('.uk-modal').is(':visible') && !check_selected() ) {
						location.reload();
					}
				}, 10000 );
				parent.setHeight('ifanswers', h);
				</script>
@endsection