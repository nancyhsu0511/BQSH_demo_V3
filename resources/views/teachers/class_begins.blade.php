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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 教材列表</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-2">
													<form class="uk-form">
														<span class="uk-text-bold"> <h2 class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」<span class="uk-text-muted" style="font-size:0.6em;">課程代碼：{{ $course[0]->course_code }}</span></h2></span>&nbsp;&nbsp;&nbsp;&nbsp;
														<span><a class="showunderline uk-text-muted uk-text-center-medium" href="{!! action('Teacher\TeacherController@student_list', [$alias, $course[0]->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-group"></i> 查看學生名單</a></span>
												</div>

												<div class="uk-width-medium-1-2">
													<div class="uk-vertical-align uk-text-right uk-text-top">
														<button onclick="javascript:;" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button disabled>上課中</button>
													</div>
												</div>
											</div>   

											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>序號</th>
														<th>類別</th>
														<th>教材主題</th>
														<th>分數</th>
														<th>管理</th>
													</tr>
												</thead>
												<tbody>
													@forelse ( $lessons as $lesson )
													<tr>
														<td>{{ $lesson->id }}</td>
														<td>{{ $lesson->category }}</td>
														<td><a href="javascript:;" class="showunderline">{{ $lesson->topic_name }}</a></td>
														<td>{{ $lesson->score }}</td>
														@if( $lesson->category == '觀念' )
															<td><a href="{!! action('Teacher\TeacherController@publish_concept', [$alias, $course[0]->course_code, $lesson->id]) !!}" class="uk-button uk-button-success" type="button">發佈</a></td>
														@elseif( $lesson->category == '練習' )
															<td><a href="{!! action('Teacher\TeacherController@publish_question', [$alias, $course[0]->course_code, $lesson->id]) !!}" class="uk-button uk-button-success" type="button">發佈</a></td>
														@else
															<td><a href="javascript:;" class="uk-button uk-button-success" type="button">發佈</a></td>
														@endif
													</tr>
													@empty
														<tr><td colspan="5">No lessons found</td></tr>
													@endforelse
												</tbody>
											</table>
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
@endsection