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
                                <li<?php echo $active_tab == 'form' ? ' class="uk-active"' : ''; ?> aria-expanded="false"><a href="#"><i class="uk-icon-cloud-upload"> </i> 教材上傳</a></li>
                            </ul>

                            <ul id="switcher-content" class="uk-switcher">

                                <li class="uk-active" aria-hidden="false">
                                    <!--2nd TAB CONTENT START-->
                                    <br />
                                    <form class="uk-form uk-form-stacked" method="post" enctype="multipart/form-data">

										{!! csrf_field() !!}
										<div class="uk-form-row">
                                            <label class="uk-form-label">類別</label>
                                            <div class="uk-form-controls">
                                                <select name="category" id="category">
													<option value="觀念"@if ($course[0]->category == '觀念') selected @endif>觀念</option>
													<option value="練習"@if ($course[0]->category == '練習') selected @endif>練習</option>
													<option value="批次上傳練習題"@if ($course[0]->category == '批次上傳練習題') selected @endif>批次上傳練習題</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">主題</label>
                                            <div class="uk-form-controls">
                                                <input type="text" name="course_name" value="{{ $course[0]->course_name }}" maxlength="255" placeholder="輸入主題名稱" class="uk-width-1-1" required />
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">內容</label>
                                            <div class="uk-form-controls">
                                                <!--textarea start-->
                                                <textarea name="description" data-uk-htmleditor="{mode:'tab'}">{{ $course[0]->description }}</textarea>
                                                <!--textarea end-->
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">影音連結</label>
                                            <div class="uk-form-controls">
                                                <input placeholder="貼上embed字串" class="uk-width-1-1" type="url" name="video_embed" value="{{ $course[0]->video_embed }}" />
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">Word 上傳</label>
                                            <div class="uk-form-controls">
                                                <div class="uk-form-file">
                                                    <button class="uk-button">選擇檔案</button>
                                                    <input type="file" name="attached_doc" />
                                                </div>
												<span><a href="{!! url('uploads/docs/'.$course[0]->attached_doc) !!}">{{ $course[0]->attached_doc }}</a></span>
                                            </div>
                                        </div>

                                        <div class="uk-form-row">
                                            <label class="uk-form-label">PDF 上傳</label>
                                            <div class="uk-form-controls">
                                                <div class="uk-form-file">
                                                    <button class="uk-button">選擇檔案</button>
                                                    <input type="file" name="attached_pdf" />
                                                </div>
												<span><a href="{!! url('uploads/pdfs/'.$course[0]->attached_pdf) !!}" target="_blank">{{ $course[0]->attached_pdf }}</a></span>
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

                        </div>
                    </div>
                </div>
@endsection