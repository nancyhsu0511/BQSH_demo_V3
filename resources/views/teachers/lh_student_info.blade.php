@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
				<script src="{!! asset('js/canvasjs.min.js') !!}"></script>
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('Teacher\TeacherController@index') !!}">選擇科目</a></li>
                        <li><span>教學專區</span></li>
                        <li class="uk-active"><span>課程列表</span></li>
                    </ul>
                    <br />
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-5">
                           <!--NAV START-->
						   @include('teachers.teacher_nav')
                            <!--NAV END-->
                        </div>

                        <div class="uk-width-medium-4-5">
							@include('shared.flasg_msgs')
                            <div class="uk-grid" data-uk-grid-margin="">
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 學習紀錄</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
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
													$marks_scored = DB::table('student_scores')->where('student_id', $student[0]->id)->where('course_id', $class->course_id)->sum('score');

													$grand_total += $course_score;
													$student_total += $marks_scored;
													?>
													<tr>
														<td><span class="uk-text-bold">{{ $class->course_name }}</span></td>
														<td>{{ round($course_score ? (($marks_scored / $course_score) * 100) : 0) }}%</td>
														<td>{{ $marks_scored }}/{{ $course_score }}</td>
														<td>
															<?php
															$scored = round($course_score ? (($marks_scored / $course_score) * 100) : 0);
															?>
															<!-- img src="{!! asset('img/infography01.png') !!}" alt="統計資訊圖表"-->
															<script>
															var chart1 = new CanvasJS.Chart("chartContainer{{ $i }}", {backgroundColor: "#EEEEEE", animationEnabled: true, data: [{ type: "doughnut", toolTipContent: "{y} %", dataPoints: [{ y: {{ $scored }} },{ y: {{ 100 - $scored }} }] }] });chart1.render(); chart1 = {};
															</script>
															<div id="chartContainer{{ $i }}" style="height: 103px; width: 141px;"></div>
														</td>
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
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-2">
												</div>
												<div class="uk-width-medium-1-2 uk-text-right">
													<a href="{!! action('Teacher\TeacherController@lh_student_list', [$alias, $course[0]->course_code]) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 回上一層</a>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
@endsection