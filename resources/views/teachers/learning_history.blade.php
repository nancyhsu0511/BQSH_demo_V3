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
												<form class="uk-form">
													<span class="uk-text-bold"><input type="text" placeholder="a001" class="uk-form-width-medium"> <a href="search_student.html" class="uk-button uk-button-primary" type="button" data-uk-button>查詢</a></span>
												</form>
												<hr class="uk-grid-divider">
												<table class="uk-table uk-table-hover">
													<thead>
														<tr>
															<th>序號</th>
															<th>教材主題</th>
															<th>學生名單</th>
															<th>功能</th>
														</tr>
													</thead>
													<tbody>
														@forelse( $courses as $course )
														<tr>
															<td>{{ $course->id }}</td>
															<td><a href="" class="uk-float-left">{{ $course->course_name }}</a></td>
															<td><a href="{!! action('Teacher\TeacherController@lh_student_list', [$alias, $course->course_code]) !!}" class="uk-button uk-button-primary" type="button" data-uk-button>學生名單</a></td>
															<td><a href="{!! action('Teacher\TeacherController@lh_student_statistics', [$alias, $course->course_code]) !!}" class="uk-button uk-button-success" type="button" data-uk-button>統計資料</a></td>
														</tr>
														@empty
															<tr><td colspan="4">No courses found.</td></tr>
														@endforelse
													</tbody>
												</table>
												<div class="uk-vertical-align uk-text-right uk-text-top">
													{!! $courses->render() !!}
												</div>
											</li>
										</ul>
									</div>
								</div>
                        </div>
                    </div>
                </div>
				<script>
				$( document ).ready( function() {
					$('.pagination').addClass('uk-pagination');
				});
				</script>
@endsection