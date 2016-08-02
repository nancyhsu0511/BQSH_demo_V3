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
							@foreach ($errors->all() as $error)
								<div class="uk-alert uk-alert-danger" data-uk-alert>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ $error }}</span>
								</div>
							@endforeach

							@if ( session('status') )
								<div class="uk-alert uk-alert-success" data-uk-success>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ session('status') }}</span>
								</div>
							@endif

							@if ( session('error') )
								<div class="uk-alert uk-alert-danger" data-uk-alert>
									<a href="" class="uk-alert-close uk-close"></a>
									<span>{{ session('error') }}</span>
								</div>
							@endif
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
													<form class="uk-form" method="get">
														{{ csrf_field() }}
														<span class="uk-text-bold">
															<h2 class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」 <span class="uk-text-muted" style="font-size:0.6em;">課程代碼：{{ $course[0]->course_code }}</span></h2>

															<input type="text" name="course_code" placeholder="輸入班級代號" class="uk-form-width-medium" required />
															<button class="uk-button uk-button-primary" type="submit" data-uk-button>送出</button>
														</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<span>
															<a class="showunderline uk-text-muted uk-text-center-medium" href="{!! action('Teacher\TeacherController@student_list', [$alias, $course[0]->course_code]) !!}" data-uk-lightbox="" data-lightbox-type="iframe"><i class="uk-icon-group"></i> 查看學生名單</a>
														</span>
													</form>
												</div>

												<div class="uk-width-medium-1-2">
													<div class="uk-vertical-align uk-text-right uk-text-top">
														<a href="{!! action('Teacher\TeacherController@class_begins', [$alias, $course[0]->course_code]); !!}" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button>開始上課</a>
													</div>

												</div>
											</div>   
											
											
											<hr class="uk-grid-divider">
											<form method="post">
												{{ csrf_field() }}
												<table class="uk-table uk-table-hover">
													<thead>
														<tr>
															<th>序號</th>
															<th>類別</th>
															<th>教材主題</th>
															<th>排序</th>
															<th>設定分數</th>
															<th>管理</th>
														</tr>
													</thead>
													<tbody>
														@forelse ( $lessons as $i => $lesson )
														<tr>
															<td>{{ $lesson->id }}<input type="hidden" name="lid_{{ $i }}" value="{{ $lesson->id }}" /></td>
															<td>{{ $lesson->category }}</td>
															<td><a href="" class="showunderline">{{ $lesson->topic_name }}</a></td>
															<td><input type="number" name="sequence_{{ $i }}" placeholder="{{ $i }}" min="1" max="{{ count($lessons) }}" value="<?php echo ($lesson->sequence ? $lesson->sequence : ''); ?>" class="uk-form-width-mini"></td>
															<td><input type="number" name="score_{{ $i }}" placeholder="{{ rand(20, 90) }}" min="0" max="100" value="<?php echo ($lesson->score ? $lesson->score : ''); ?>" class="uk-form-width-mini"></td>
															<td>
																<a href="{!! action('Teacher\TeacherController@lesson_edit', [$alias, $lesson->id]) !!}" class="uk-button uk-button-success" type="button" data-uk-button>編輯</a>
																<a href="{!! action('Teacher\TeacherController@lesson_delete', [$alias, $lesson->id]) !!}" class="uk-button uk-button-danger lesson_del" type="button" data-uk-button>刪除</a>
															</td>
														</tr>
														@empty
															<td colspan="6">No lessons found!</td>
														@endforelse
													</tbody>
												</table>
												<div class="uk-form-row">
													<div class="uk-form-controls">
														<button class="uk-button uk-button-primary">儲存</button>
													</div>
												</div>
											</form>
										</li>
									</ul>
								</div>
							</div>
                        </div>
                    </div>
                </div>
				<script>
				$( document ).ready( function() {
					$('.lesson_del').click( function() {
						return confirm("Are you sure to delete this lesson?\n\nAll attached files and lesson data will be deleted.");
					});
				});
				</script>
@endsection