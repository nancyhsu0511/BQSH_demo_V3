@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('Teacher\TeacherController@index') !!}">數學科</a></li>
                        <li><span>題庫管理</span></li>
                        <li class="uk-active"><span>科目選擇</span></li>
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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 題庫管理</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-1">
													
													<form class="uk-form">
														<div class=" uk-text-right">
															<a href="{!! action('Teacher\TeacherController@test_bank_list', $subject) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 回上一層</a>
														</div>
														<span class="uk-text-bold"> <h2 class="uk-text-primary uk-text-bold">數學科</h2><p>第一章、數與式</p></span>
													</form>
												</div>
											</div>   

											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-1">
													<button onclick="window.location.href='lesson_list.2.html'" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button disabled>自動出題</button>
													<p class="uk-text-bold">單選題</p>
													<div class="uk-panel">
														<div class="uk-panel uk-panel-box">
															<ul class="uk-nav uk-nav-parent-icon">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/01.png') !!}">
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/02.png') !!}">
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/03.png') !!}">
																</li>
															</ul>
														</div>
													</div>


													<p class="uk-text-bold">填充題</p>
													<div class="uk-panel">
														<div class="uk-panel uk-panel-box">
															<ul class="uk-nav uk-nav-parent-icon">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/01.png') !!}">
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/02.png') !!}">
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <img src="{!! asset('img/quiz/03.png') !!}">
																</li>
															</ul>
														</div>
													</div>
									
													<div class="uk-form-row">
														<div class="uk-form-controls">
															<br />
															<a href="{!! action('Teacher\TeacherController@test_bank_auto', $subject) !!}" class="uk-button uk-button-success uk-text-right">加入教材</a>
														</div>
													</div>
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