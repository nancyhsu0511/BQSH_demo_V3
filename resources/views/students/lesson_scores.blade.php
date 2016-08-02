@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('Student\StudentController@index') !!}">選擇科目</a></li>
                        <li><span>課程專區</span></li>
                        <li class="uk-active"><span>教材列表</span></li>
                    </ul>
                    <br />
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-5">
                           <!--NAV START-->
						   @include('students.nav')
                           <!--NAV END-->
                        </div>

                        <div class="uk-width-medium-4-5">
							@include('shared.flasg_msgs')
                            <div class="uk-grid" data-uk-grid-margin="">
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="false"><a href="#"><i class="uk-icon-list-alt"></i> 課程專區</a></li>
										<li aria-expanded="true"><a href="#"><i class="uk-icon-clock-o"> </i> 學習紀錄</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form">
												<span class="uk-text-bold"><input type="text" placeholder="輸入課程代號" class="uk-form-width-medium"> <button class="uk-button uk-button-primary" type="button" data-uk-button>加入</button></span>
											</form>
											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>序號</th>
														<th>教材主題</th>
														<th>已獲得分數</th>
														<th>授課老師</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $lessons as $i => $row )
													<tr>
														<td>{{ ($i < 10 ? '0' : '').$i }}</td>
														<td><a href="{!! action('Student\StudentController@'.($row->category == '練習' ? 'lesson_question' : 'lesson_concept'), [$alias, $course_code, $row->id]) !!}" class="uk-float-left showunderline">{{ $row->topic_name }}</a></td>
														<td><?php
														$score = DB::table('student_scores')
																	->where('student_id', Auth::user()->id)
																	->where('lesson_id', $row->id)
																	->value('score');
														echo $score ? $score : 0;
														?></td>
														<td><?php
															$course = DB::table('courses')
																		->join('users', 'users.id', '=', 'courses.teacher_id')
																		->select('users.first_name', 'users.last_name', 'courses.course_name', 'courses.course_code')
																		->where('courses.id', $row->course_id)->get();
															echo $course[0]->first_name.' '.$course[0]->last_name;
														?></td>
													</tr>
												@empty
												@endforelse
												<tbody>
											</table>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br /> 
												   
											<form class="uk-form">
												<span class="uk-text-bold uk-text-large uk-text-primary">林梳雲</span> 的學習紀錄
											</form>
											<br />
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>課程名稱</th>
														<th>練習答對率</th>
														<th>獲得分數</th>
														<th>統計資訊圖表</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$grand_total = $student_total = 0;
												?>
												@forelse( $classes as $i => $class )
													<?php
													$course = DB::table('courses')->where('id', $class->course_id)->get();
													$course_score = DB::table('lessons')->where('course_id', $class->course_id)->sum('score');
													$marks_scored = DB::table('student_scores')->where('student_id', Auth::user()->id)->where('course_id', $class->course_id)->sum('score');

													$grand_total += $course_score;
													$student_total += $marks_scored;
													?>
													<tr>
														<td><span class="uk-text-bold">{{ $class->course_name }}</span></td>
														<td>{{ round($course_score ? (($marks_scored / $course_score) * 100) : 0) }}%</td>
														<td>{{ $marks_scored }}/{{ $course_score }}</td>
														<td><img src="{!! asset('img/infography01.png') !!}" alt="統計資訊圖表"></td>
													</tr>
												@empty
													<tr><td colspan="4">No information found!</td></tr>
												@endforelse
												</tbody>
												<tfoot>
													<tr>
														<td colspan="2">課程總和</td>
														<td><span class="uk-text-bold uk-text-large uk-text-danger">{{ round($grand_total ? (($student_total / $grand_total) * 100) : 0) }}%</span></td>
														<td>{{ $student_total }}/{{ $grand_total }}</td>
													</tr>
												</tfoot>
											</table>
											<!--2nd TAB CONTENT END-->
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
@endsection