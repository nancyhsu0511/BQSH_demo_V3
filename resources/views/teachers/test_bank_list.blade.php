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
														<span class="uk-text-bold"> <h2 class="uk-text-primary uk-text-bold">數學科</h2></span>
														<ul class="uk-subnav uk-subnav-pill">
															<li class="uk-active"><a href="">第一冊</a></li>
															<li><a href="">第二冊</a></li>
															<li><a href="">第三冊</a></li>
															<li><a href="">第四冊</a></li>
															<li><a href="">數學甲（上）</a></li>
															<li><a href="">數學乙（上）</a></li>
															<li><a href="">數學甲（下）</a></li>
															<li><a href="">數學乙（下）</a></li>
														</ul>
													</form>
												</div>
											</div>   

											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-4-5">
													<div class="uk-panel">
														<div class="uk-panel uk-panel-box">
															
															<ul class="uk-nav uk-nav-parent-icon">
																<li class="uk-parent">
																	<input type="checkbox" checked="checked"> <span class="uk-text-large">第一章、數與式</span>
																	<ul class="uk-nav-sub">
																		<li><input type="checkbox"> <span>第一節、數與數線</span></li>
																		<li><input type="checkbox"> <span>第二節、數線上的幾何</span></li>
																	</ul>
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <span class="uk-text-large">第二章、多項式函數</span>
																	<ul class="uk-nav-sub">
																		<li><input type="checkbox"> <span>第一節、簡單多項式函數及其圖形</span></li>
																		<li><input type="checkbox"> <span>第二節、多項式的運算與應用</span></li>
																	</ul>
																</li>
																<hr class="uk-grid-divider">
																<li class="uk-parent">
																	<input type="checkbox"> <span class="uk-text-large">第三章、三角函數</span>
																	<ul class="uk-nav-sub">
																		<li><input type="checkbox"> <span>第一節、簡單多項式函數及其圖形</span></li>
																		<li><input type="checkbox"> <span>第二節、多項式的運算與應用</span></li>
																	</ul>
																</li>
															</ul>
														</div>
													</div>
													<!-- <div class="uk-form-row">
														<div class="uk-form-controls">
															<button class="uk-button uk-button-primary">儲存</button>
														</div>
													</div> -->
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<br />
                                        
                            <a href="{!! action('Teacher\TeacherController@test_bank_auto', $subject) !!}" class="uk-button uk-button-success uk-text-right">快速出題</a>
                            <a href="{!! action('Teacher\TeacherController@test_bank_manual', $subject) !!}" class="uk-button uk-button-success uk-text-right">手動出題</a>
                        </div>
                    </div>
                </div>
@endsection