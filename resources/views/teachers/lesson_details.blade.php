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
								<?php $active_tab = session('tab'); ?>
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 教材列表</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />
											<div class="uk-grid" data-uk-grid-margin="">
												<div class="uk-width-medium-1-2">
													<a href="{!! action('Teacher\TeacherController@lesson_list', [$alias]) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 返回教材列表</a>
													<!-- <h3>觀念：<span class="uk-text-primary uk-text-bold">「拋物線」</span></h3> -->
												</div>
												<div class="uk-width-medium-1-2 uk-text-right">
													<a href="{!! action('Teacher\TeacherController@lesson_edit', [$alias, $lesson[0]->id]) !!}" class="uk-button uk-button-success uk-text-right">編輯課程</a>
												</div>
											</div>
											<br />
											{!! $lesson[0]->description !!}
											<br /><br />
											@if( trim($lesson[0]->attached_doc) )
											<a href="{!! asset('uploads/docs/'.$lesson[0]->attached_doc) !!}">Word文档</a>
											<br /><br />
											@endif
											@if( trim($lesson[0]->attached_pdf) )
											<iframe src="{!! asset('uploads/pdfs/'.$lesson[0]->attached_pdf) !!}" width="100%" height="600"></iframe>
											<br /><br />
											@endif
											<hr class="uk-grid-divider" />

											@if( count($answers) )
												類別: <b>{{ $lesson[0]->category }}</b><br />
												題型: <b>{{ $lesson[0]->question_type }}</b><br />
												@if( $lesson[0]->question_type == '單選題' )
													選項:<br /><b>
													@foreach( $answers as $i => $answer )
														{{ '&#'.($i + 65).';) '.$answer->answer }}<br />
													@endforeach</b>
												@else
													答案: <b>{{ $answers[0]->answer }}</b>
												@endif
											@endif
										</li>
									</ul>
								</div>
							</div>

                        </div>
                    </div>
                </div>
@endsection