@extends('master1')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">

                    <!-- <ul class="uk-subnav uk-subnav-pill" data-uk-switcher="{connect:'#switcher-content'}">
                        <li aria-expanded="true" class="uk-active"><a href="#">備課專區</a></li>
                        <li aria-expanded="false"><a href="#">教學專區</a></li>
                        <li aria-expanded="false"><a href="#">學習紀錄</a></li>
                        <li aria-expanded="false"><a href="#">題庫管理</a></li>
                    </ul> -->
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('Teacher\TeacherController@index') !!}">選擇科目</a></li>
                        <li><span>備課專區</span></li>
                        <li class="uk-active"><span>教材列表</span></li>
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
							<?php $active_tab = session('tab'); ?>
                            <ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
                                <li<?php echo $active_tab == 'form' ? '' : ' class="uk-active"'; ?> aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 教材列表</a></li>
                                <li<?php echo $active_tab == 'form' ? ' class="uk-active"' : ''; ?> aria-expanded="false"><a href="#"><i class="uk-icon-cloud-upload"> </i> 教材上傳</a></li>
                            </ul>

                            <ul id="switcher-content" class="uk-switcher">

                                <li aria-hidden="true">
                                    <br />      
                                    <form class="uk-form">
                                        <span class="uk-text-bold"> 將勾選的教材加入 <input type="text" placeholder="機率與統計（三甲）" class="uk-form-width-medium"> <button onclick="window.location.href='lesson_list02.html'" class="uk-button uk-button-primary" type="button" data-uk-button>送出</button></span>
                                    </form>
                                    <hr class="uk-grid-divider">
                                    <table class="uk-table uk-table-hover">
										<thead>
											<tr>
												<th>選擇</th>
												<th>序號</th>
												<th>編輯日期</th>
												<th>類別</th>
												<th>教材主題</th>
												<th>課程名稱</th>
												<th>管理</th>
											</tr>
										</thead>
										<tbody>
										@forelse( $courses as $course )
											<tr>
												<td><input type="checkbox" name="course_id[]" value="{!! $course->id !!}" /></td>
												<td>{!! $course->id !!}</td>
												<td>{!! date('Ymd', strtotime($course->updated_at)) !!}</td>
												<td>{!! $course->category !!}</td>
												<td><?php
													$subject_name = DB::table('subjects')->where('id', $course->subject_id)->value('name');
													echo $subject_name;
												?></td>
												<td><a href="{!! action('Teacher\TeacherController@lesson_list', [$alias, $course->id]) !!}">{!! $course->course_name !!}</a></td>
												<td>
													<a href="courses/{!! $course->id !!}/edit" class="uk-button uk-button-success" type="button" data-uk-button>編輯</a>
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
                                    <form class="uk-form uk-form-stacked" method="post" enctype="multipart/form-data">

										{!! csrf_field() !!}
										<div class="uk-form-row">
                                            <label class="uk-form-label">類別</label>
                                            <div class="uk-form-controls">
                                                <select name="category" id="category">
                                                    <option>觀念</option>
                                                    <option>練習</option>
                                                    <option>批次上傳練習題</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">主題</label>
                                            <div class="uk-form-controls">
                                                <input type="text" name="course_name" value="{{ old('course_name') }}" maxlength="255" placeholder="輸入主題名稱" class="uk-width-1-1" required />
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">內容</label>
                                            <div class="uk-form-controls">
                                                <!--textarea start-->
                                                <textarea name="description" data-uk-htmleditor="{mode:'tab'}">{{ old('description') }}</textarea>
                                                <!--textarea end-->
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">影音連結</label>
                                            <div class="uk-form-controls">
                                                <input placeholder="貼上embed字串" class="uk-width-1-1" type="url" name="video_embed" value="{{ old('video_embed') }}" />
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">Word 上傳</label>
                                            <div class="uk-form-controls">
                                                <div class="uk-form-file">
                                                    <button class="uk-button">選擇檔案</button>
                                                    <input type="file" name="attached_doc" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">PDF 上傳</label>
                                            <div class="uk-form-controls">
                                                <div class="uk-form-file">
                                                    <button class="uk-button">選擇檔案</button>
                                                    <input type="file" name="attached_pdf" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <div class="uk-form-controls">
                                                <button type="submit" class="uk-button uk-button-primary">儲存</button>
                                            </div>
                                        </div>

                                    </form>
                                    <!--2nd TAB CONTENT END-->
                                </li>
                            </ul>
                        </div>
                    </div>
				<script>
				$( document ).ready( function() {
					$('.course_del').click( function() {
						return confirm("Are you sure to delete this course?\n\nAll associated lessons and attached files will be deleted.");
					});
				});
				$('.pagination').addClass('uk-pagination');
				</script>

                        </div>
                    </div>
                </div>
@endsection