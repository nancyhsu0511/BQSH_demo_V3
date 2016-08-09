@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('BaseController@index') !!}">管理員登入</a></li>
                        <li><span>學生設定</span></li>
                        <li class="uk-active"><span>學生列表</span></li>
                    </ul>
                    <br />

					@include('shared.flasg_msgs')
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-5">
                           <!--NAV START-->
						   @include('admin.nav_tabs')
                            <!--NAV END-->
                        </div>

                        <div class="uk-width-medium-4-5">
                            <div class="uk-grid" data-uk-grid-margin="">
								@include('admin.page_tabs')
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 學生列表</a></li>
										<li aria-expanded="false"><a href="#"><i class="uk-icon-plus-square-o"> </i> 增加名單</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form" method="post" action="{!! action('Admin\AdminController@search_student') !!}">
												{!! csrf_field() !!}
												<input type="text" name="keyw" placeholder="輸入學生帳號" class="uk-form-width-medium" required>
												<button class="uk-button uk-button-primary" type="submit" data-uk-button>搜尋</button>
											</form>
											<hr class="uk-grid-divider">
											<?php
											$courses = DB::table('courses')->get();
											?>
											<ul class="uk-subnav uk-subnav-pill">
												<li<?php echo isset($course_code) ? '' : ' class="uk-active"'; ?>><a href="{!! action('Admin\AdminController@acc_students') !!}">所有学生</a></li>
											@forelse( $courses as $course )
												<li<?php echo (isset($course_code) && $course->course_code == $course_code ? ' class="uk-active"' : '') ?>><a href="{!! action('Admin\AdminController@course_students', $course->course_code) !!}">{{ $course->course_name }}</a></li>
												<?php if(isset($course_code) && $course->course_code == $course_code) { $course_name = $course->course_name; } ?>
											@empty
											@endforelse
											</ul>
											@if( $page_mode == 'list' )
												@if(isset($course_code))
												<table class="uk-table uk-table-hover">
													<thead>
														<tr>
															<th>學號</th>
															<th>班級</th>
															<th>座號</th>
															<th>姓名</th>
														</tr>
													</thead>
													<tbody>
														@forelse( $students as $i => $student )
														<tr>
															<td>{{ ($student->id < 10 ? '00' : ($student->id < 100 ? '0' : '')).$student->id }}</td>
															<td>{{ $course_name }}</td>
															<td>{{ $student->seat_no }}</td>
															<td>{{ $student->first_name.' '.$student->last_name }}</td>
														</tr>
														@empty
														<tr><td colspan="4">No students found</td></tr>
														@endforelse
													</tbody>
												</table>
												@else
												<hr class="uk-grid-divider">
												<form class="uk-form" method="post" action="{!! action('Admin\AdminController@add_student_course') !!}">
												<span class="uk-text-bold"> 当然添加 
													{!! csrf_field() !!}
													<input type="text" name="course_code" value="{{ old('course_code') }}" placeholder="进入课程代码" class="uk-form-width-medium" required />
													<button class="uk-button uk-button-primary" type="submit" data-uk-button>送出</button>
												</span>
												<hr class="uk-grid-divider">
												<table class="uk-table uk-table-hover">
													<thead>
														<tr>
															<th></th>
															<th>學號</th>
															<!--th>班級</th>
															<th>座號</th-->
															<th>姓名</th>
															<th>email</th>
														</tr>
													</thead>
													<tbody>
														@forelse( $students as $i => $student )
														<tr>
															<td>
																<input type="checkbox" name="student_ids[]" value="{{ $student->id }}" />
															</td>
															<td>{{ ($student->id < 10 ? '00' : ($student->id < 100 ? '0' : '')).$student->id }}</td>
															<!--td></td>
															<td>{{ ++$i }}</td-->
															<td>{{ $student->first_name.' '.$student->last_name }}</td>
															<td>{{ $student->email }}</td>
														</tr>
														@empty
														<tr><td colspan="4">No students found</td></tr>
														@endforelse
													</tbody>
												</table>
												</form>
												@endif
											@else
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>學號</th>
														<th>班級</th>
														<th>座號</th>
														<th>姓名</th>
													</tr>
												</thead>
												<tbody>
													@forelse( $students as $i => $student )
													<tr>
														<td>{{ ($student->id < 10 ? '00' : ($student->id < 100 ? '0' : '')).$student->id }}</td>
														<td>{{ $student->course_name }}</td>
														<td>{{ $student->seat_no }}</td>
														<td>{{ $student->first_name.' '.$student->last_name }}</td>
													</tr>
													@empty
													<tr><td colspan="4">No students found</td></tr>
													@endforelse
												</tbody>
											</table>
											@endif
											<div class="uk-vertical-align uk-text-right uk-text-top">
												{!! $students->render() !!}
											</div>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br />
												<div class="uk-form-row">
													<label class="uk-form-label">手動新增</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<form class="uk-panel uk-form" method="post">
																{!! csrf_field() !!}
																<div class="uk-form-row">
																	<input type="hidden" name="user_role" value="1" />
																	<input class="uk-width-5-5 uk-form-large" type="text" name="first_name" placeholder="名字" value="{{ old('first_name') }}" required />
																	<input class="uk-width-5-5 uk-form-large" type="text" name="last_name" placeholder="姓" value="{{ old('last_name') }}" required />
																	<input class="uk-width-5-5 uk-form-large" type="email" name="email" placeholder="email" value="{{ old('email') }}" required />
																	<button type="submit" class="uk-width-2-5 uk-button uk-button-danger" style="float:right;">搜尋</button>
																</div>
															</form>
														</div>
													</div>

												</div>
												<hr class="uk-grid-divider">
												<div class="uk-form-row">
													<label class="uk-form-label">批次上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button><span class="uk-text-muted">（可匯入EXCEL或CSV表單）</span>
															<input type="file">
														</div>
													</div>

												</div>

												<div class="uk-form-row">
													<div class="uk-form-controls">
														<button class="uk-button uk-button-primary">上傳</button>
													</div>
												</div>

												<br /><br />
													<p class="uk-texxt-bold">格式範例：</p>
													<table class="uk-table">
														<thead>
															<tr>
																<th>學號</th>
																<th>班級</th>
																<th>座號</th>
																<th>姓名</th>
															</tr>
														</thead>
														<tr>
															<td>a001</td>
															<td>甲班</td>
															<td>1</td>
															<td>陳品屏</td>
														</tr>
													</table>
											<!--2nd TAB CONTENT END-->
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
				</div>
				<script>
				$('.pagination').addClass('uk-pagination');
				</script>
@endsection