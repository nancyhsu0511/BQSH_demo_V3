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
											<span class="uk-text-bold uk-text-large uk-text-primary">「{{ $course[0]->course_name }}」</span> 學生名單
											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>帳號</th>
														<th>學號</th>
														<th>班級</th>
														<th>座號</th>
														<th>姓名</th>
														<th>上次登入時間</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $student_list as $i => $student )
												<tr>
													<td>a{{ ($student->id < 10 ? '00' : ($student->id < 100 ? '0' : '')).$student->id }}</td>
													<td>{{ date('yndhi', strtotime($student->created_at)) }}</td>
													<td>{{ $course[0]->course_name }}</td>
													<td>{{ $i+1 }}</td>
													<td><a href="{!! action('Teacher\TeacherController@lh_student_info', [$alias, $course[0]->course_code, $student->id]) !!}" class="showunderline">{{ $student->first_name.' '.$student->last_name }}</a></td>
													<td>{{ date('md-h:i', strtotime($student->created_at)) }}</td>
												</tr>
												@empty
												@endforelse
												</tbody>
											</table>
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
				<script>
				$( document ).ready( function() {
					$('.pagination').addClass('uk-pagination');
				});
				</script>
@endsection