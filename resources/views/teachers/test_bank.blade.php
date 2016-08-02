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
										<li class="uk-active" aria-expanded="true"><a href="lesson_list.html"><i class="uk-icon-list-alt"></i> 科目選擇</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />
											 <!--SUBJECT-->
											<div class="uk-grid" data-uk-grid-margin="">
												@forelse( $subject_list as $subject )
												<div class="uk-width-medium-1-3 uk-text-center">
													<figure class="uk-overlay uk-overlay-hover">
														<a href="{!! action('Teacher\TeacherController@test_bank_list', $subject->alias) !!}">
															<img src="{!! asset('img/'.$subject->img.'-on.png') !!}" width="241" height="240" alt="{!! $subject->name !!}">
															<img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/'.$subject->img.'-off.png') !!}" width="241" height="240" alt="{!! $subject->name !!}">
														<h3>{!! $subject->name !!}</h3></a>
													</figure>
												</div>
												@empty
													&nbsp;
												@endforelse
											<!--SUBJECT-->
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
@endsection