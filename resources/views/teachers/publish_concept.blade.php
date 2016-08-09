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
													<form class="uk-form" method="post">
														<span class="uk-text-bold">
															<h2 class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」<span class="uk-text-muted" style="font-size:0.6em;">課程代碼：{{ $course[0]->course_code }}</span></h2>
																<!-- <input type="text" placeholder="輸入班級代號" class="uk-form-width-medium">
																<button onclick="window.location.href='lesson_list.2.html'" class="uk-button uk-button-primary" type="button" data-uk-button>送出</button> -->
														</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<span>
															<a class="showunderline uk-text-muted uk-text-center-medium" href="{!! action('Teacher\TeacherController@student_list', [$alias, $course[0]->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-group"></i> 查看學生名單</a>
														</span>
												</div>

												<div class="uk-width-medium-1-2">
													<div class="uk-vertical-align uk-text-right uk-text-top">
														<button onclick="javascript:;" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button disabled>上課中</button>
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

													<hr class="uk-grid-divider">
													<form class="uk-form">
														
													</form>
													<form class="uk-form">
														設定教材關閉時間：<input type="text" placeholder="0" class="uk-form-width-mini"> 天 <input type="text" placeholder="0" class="uk-form-width-mini"> 時 <input type="text" placeholder="50" class="uk-form-width-mini"> 分 &nbsp;&nbsp;&nbsp;&nbsp;<button class="uk-button uk-button-primary" type="button" data-uk-button>修改</button>
														<br />
														（預設為50分鐘）
													</form>
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