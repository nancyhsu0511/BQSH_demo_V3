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
										<li aria-expanded="false"><a href="#"><i class="uk-icon-list-alt"></i> 課程專區</a></li>
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-clock-o"> </i> 學習紀錄</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form" method="post">
												{!! csrf_field() !!}
												<span class="uk-text-bold">
													<input type="text" placeholder="輸入課程代號" name="course_code" class="uk-form-width-medium" required />
													<button class="uk-button uk-button-primary" type="submit" data-uk-button>加入</button>
												</span>
											</form>
											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>序號</th>
														<th>教材主題</th>
														<th>授課老師</th>
													</tr>
												</thead>
												@forelse( $classes as $i => $class )
													<?php
													// $course = DB::table('courses')
																// ->join('users', 'users.id', '=', 'courses.teacher_id')
																// ->select('users.first_name', 'users.last_name', 'courses.course_name', 'courses.course_code')
																// ->where('courses.id', $course_id)->get();
													?>
													<tr>
														<td>{{ ($i < 10 ? '0' : '').$i }}</td>
														<td><a href="{!! action('Student\StudentController@lesson_scores', [$alias, $class->course_code]) !!}" class="uk-float-left showunderline">{{ $class->course_name }}</a></td>
														<td>{{ $class->first_name.' '.$class->last_name }}</td>
													</tr>
												@empty
													<tr><td colspan="3">No information found!</td></tr>
												@endforelse
												</tbody>
											</table>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br /> 
												   
											<form class="uk-form">
												<span class="uk-text-bold uk-text-large uk-text-primary">{{ $student[0]->first_name.' '.$student[0]->last_name }}</span> 的學習紀錄
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