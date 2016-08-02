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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 課程列表</a></li>                                
									</ul>

									<ul id="switcher-content" class="uk-switcher">

										<li aria-hidden="true">
											<br />      
										   
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														
														<th>序號</th>
														<th>編輯日期</th>
														<th>課程主題</th>
														<th>課程代號</th>
														<th>課程總分</th>
														<th>管理</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $courses as $course )
													<tr>
														<td>{!! $course->id !!}</td>
														<td>{!! date('Ymd', strtotime($course->updated_at)) !!}</td>
														<td><a href="{!! action('Teacher\TeacherController@lesson_list_content', [$alias, $course->course_code]) !!}" class="showunderline">{!! $course->course_name !!}</a></td>
														<td>{!! $course->course_code !!}</td>
														<td><?php
														$total_score = DB::table('lessons')->where('course_id', $course->id)->sum('score');
														echo $total_score;
														?></td>
														<td>
															<a class="uk-button uk-button-primary" href="{!! action('Teacher\TeacherController@copy_course', [$alias, $course->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe">複製</a>
															<a class="uk-button uk-button-success" href="{!! action('Teacher\TeacherController@share_course', [$alias, $course->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe">分享</a>
															<a href="courses/{!! $course->id !!}/delete" class="uk-button uk-button-danger course_del" type="button" data-uk-button>刪除</a>
														</td>
													</tr>
												@empty
													<tr>
														<td colspan="7">No courses found!</td>
													</tr>
												@endforelse
												</tbody>
											</table>
											<div class="uk-vertical-align uk-text-right uk-text-top">
												{!! $courses->render() !!}
											</div>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br />
											<form class="uk-form uk-form-stacked">

												<div class="uk-form-row">
													<label class="uk-form-label">類別</label>
													<div class="uk-form-controls">
														<select>
															<option>觀念</option>
															<option>練習</option>
															<option>批次上傳練習題</option>
														</select>
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">主題</label>
													<div class="uk-form-controls">
														<input placeholder="輸入主題名稱" class="uk-width-1-1" type="text">
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">內容</label>
													<div class="uk-form-controls">
														<!--textarea start-->
														<textarea data-uk-htmleditor="{mode:'tab'}"></textarea>
														<!--textarea end-->
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">影音連結</label>
													<div class="uk-form-controls">
														<input placeholder="貼上embed字串" class="uk-width-1-1" type="text">
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">Word 上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button>
															<input type="file">
														</div>
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">PDF 上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button>
															<input type="file">
														</div>
													</div>
												</div>

												<div class="uk-form-row">
													<div class="uk-form-controls">
														<button class="uk-button uk-button-primary">儲存</button>
													</div>
												</div>

											</form>
											<!--2nd TAB CONTENT END-->
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<script>
				$( document ).ready( function() {
					$('.course_del').click( function() {
						return confirm("Are you sure to delete this course?\n\nAll associated lessons and attached files will be deleted.");
					});

					$('.pagination').addClass('uk-pagination');
				});
				</script>
@endsection