@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
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
										<li class="uk-active" aria-expanded="true"><a href="lesson_list.html"><i class="uk-icon-list-alt"></i> 教材列表</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">

										<li aria-hidden="true">
											<br />
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-2">
														<span class="uk-text-bold">
															<h2 class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」<span class="uk-text-muted" style="font-size:0.6em;">課程代碼：{{ $course[0]->course_code }}</span></h2>
															<!-- <input type="text" placeholder="輸入班級代號" class="uk-form-width-medium"> <button onclick="window.location.href='lesson_list.2.html'" class="uk-button uk-button-primary" type="button" data-uk-button>送出</button> -->
														</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<span>
															<a class="showunderline uk-text-muted uk-text-center-medium" href="{!! action('Teacher\TeacherController@student_list', [$alias, $course[0]->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-group"></i> 查看學生名單</a>
														</span>
												</div>

												<div class="uk-width-medium-1-2">
													<div class="uk-vertical-align uk-text-right uk-text-top">
														<button onclick="window.location.href='lesson_list.2.html'" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button disabled>上課中</button>
													</div>

												</div>
											</div>   

											<hr class="uk-grid-divider">
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-1">
													<div class="uk-grid" data-uk-grid-margin="">
														<div class="uk-width-medium-1-2">
															<a href="{!! action('Teacher\TeacherController@class_begins', [$alias, $course[0]->course_code]) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 返回教材列表</a>
															<!-- <h3>觀念：<span class="uk-text-primary uk-text-bold">「拋物線」</span></h3> -->
														</div>
														<div class="uk-width-medium-1-2 uk-text-right">
															<button class="uk-button uk-button-success uk-text-right" type="button">隱藏學生端資訊</button>
														</div>
													</div>
													<br />
													<a class="uk-button uk-button-primary uk-text-right" href="{!! action('Teacher\TeacherController@general_mode_time', [$alias, $course[0]->course_code, $lesson[0]->id]) !!}" data-uk-lightbox="" data-lightbox-type="iframe">一般模式</a>
													<a class="uk-button uk-button-primary uk-text-right" href="{!! action('Teacher\TeacherController@answer_mode_time', [$alias, $course[0]->course_code, $lesson[0]->id]) !!}" data-uk-lightbox="" data-lightbox-type="iframe">搶答模式</a>

													
													<br /><br />
													{!! $lesson[0]->description !!}
													<br /><br />
													@if( trim($lesson[0]->attached_doc) )
													<!-- a href="{!! asset('uploads/docs/'.$lesson[0]->attached_doc) !!}">Word文档</a -->
													<iframe src="http://docs.google.com/gview?url={!! asset('uploads/docs/'.$lesson[0]->attached_doc) !!}&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>
													<br /><br />
													@endif
													@if( trim($lesson[0]->attached_pdf) )
													<iframe src="http://docs.google.com/gview?url={!! asset('uploads/pdfs/'.$lesson[0]->attached_pdf) !!}&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>
													<br /><br />
													@endif
													<?php
													if( $lesson[0]->question_type == '單選題' ) {
														$correct_answer = DB::table('questions')->where('lesson_id', $lesson[0]->id)->where('correct', '!=', '')->get();
													} else {
														$correct_answer = DB::table('questions')->where('lesson_id', $lesson[0]->id)->get();
													}
													?>
													<span class="uk-float-right">正確答案：<span class="uk-text-bold uk-text-large"> {{ $correct_answer[0]->answer }} </span> &nbsp;&nbsp;&nbsp;&nbsp;<button class="uk-button uk-button-danger" type="button">公布答案</button></span>
													<div style="clear:both"></div>
													<!-- <button class="uk-button uk-button-danger" type="button">公布答案</button> -->
													
													<hr class="uk-grid-divider">
													<form class="uk-form" method="post">
														設定教材關閉時間：
														<?php
														$days = $hour = $mins = 0;
														if( $lesson[0]->lesson_closing_time ) {
															$closing_time = json_decode( $lesson[0]->lesson_closing_time );
															$days = $closing_time->days;
															$hour = $closing_time->hours;
															$mins = $closing_time->minutes;
														}
														?>
														{!! csrf_field() !!}
														<input type="number" name="days" value="{{ $days }}" min="0" placeholder="0" class="uk-form-width-mini">&nbsp;天&nbsp;
														<input type="number" name="hour" value="{{ $hour }}" min="0" max="23" placeholder="0" class="uk-form-width-mini">&nbsp;時&nbsp;
														<input type="number" name="mins" value="{{ $mins }}" min="0" max="59" placeholder="50" class="uk-form-width-mini">&nbsp;分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<button class="uk-button uk-button-primary" type="submit" data-uk-button>修改</button>
														<br />
														（預設為50分鐘）

														<hr class="uk-grid-divider">
														<p>剩餘答題時間： <span class="uk-text-danger uk-text-bold uk-text-large">5 秒</span></p>
													</form>
													<hr class="uk-grid-divider">
													<iframe id="ifanswers" src="{!! action('Teacher\TeacherController@student_answers', [$alias, $course[0]->course_code, $lesson[0]->id]) !!}" width="100%"></iframe>

													@if( count($selected_for_vote) )
													<hr class="uk-grid-divider">
													<iframe id="ifvotes" src="{!! action('Teacher\TeacherController@student_votes', [$alias, $course[0]->course_code, $lesson[0]->id]) !!}" width="100%"></iframe>
													@endif
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<script>
				var setHeight = function( f, h ) {
					$('#'+f).attr('height', h);
				}
				</script>
@endsection