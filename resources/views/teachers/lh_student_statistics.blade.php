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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 學習紀錄</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<span class="uk-text-bold uk-text-large uk-text-primary">「圓錐曲線」</span> 統計資料
											<hr class="uk-grid-divider">
											<img src="{!! asset('img/infographic.png') !!}" alt="資訊圖表">
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-2">
												</div>
												<div class="uk-width-medium-1-2 uk-text-right">
													<a href="{!! action('Teacher\TeacherController@learning_history', $alias) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 回上一層</a>
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