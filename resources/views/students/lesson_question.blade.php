@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('Student\StudentController@index') !!}">選擇科目</a></li>
                        <li><span>課程專區</span></li>
                        <li class="uk-active"><span>教材列表</span></li>
                    </ul>
                    <br />
                    <div class="uk-grid" data-uk-grid-margin="">
                        <div class="uk-width-medium-1-5">
                           <!--NAV START-->
						   @include('students.nav')
                           <!--NAV END-->
                        </div>

                        <div class="uk-width-medium-4-5">
							@include('shared.flasg_msgs')
							<div class="uk-grid" data-uk-grid-margin="">
								<div class="uk-width-medium-1-1">
									<div class="uk-grid" data-uk-grid-margin="">
										<div class="uk-width-medium-1-1">
											<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
												<li class="uk-active" aria-expanded="true"><a href="lesson_list.html"><i class="uk-icon-list-alt"></i> 教材列表</a></li>
											</ul>

											<ul id="switcher-content" class="uk-switcher">
												<li aria-hidden="true">
													<br />
													<div class="uk-grid" data-uk-grid-margin="">
														<div class="uk-width-medium-1-2">
														<span class="uk-text-bold"> <h2 class="uk-text-primary uk-text-bold">「{{ $lesson[0]->topic_name }}」</h2></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="uk-text-muted"><i class="uk-icon-star"></i> 已獲得 87 分</span>
														</div>
														<div class="uk-width-medium-1-2 uk-text-right">
															 <a href="{!! action('Student\StudentController@lesson_scores', [$alias, $course[0]->course_code]) !!}" class="showunderline"><i class="uk-icon-angle-left"></i> 返回教材列表</a>
														</div>
													</div>
													<div class="uk-grid" data-uk-grid-margin="">
														<div class="uk-width-medium-1-2">
															<button onclick="" class="uk-button uk-button-primary uk-button-large" type="button" data-uk-button disabled>一般模式</button>
														</div>

														<div class="uk-width-medium-1-2">
														</div>
													</div>   

													<hr class="uk-grid-divider">

													<div class="uk-grid" data-uk-grid-margin="">
														<div class="uk-width-medium-1-1">
															<div class="uk-panel">
																<div class="uk-panel uk-panel-box">
																	<br />
																	{!! $lesson[0]->description !!}
																	<br /><br />
																	@if( trim($lesson[0]->attached_doc) )
																	<!-- a href="{!! asset('uploads/docs/'.$lesson[0]->attached_doc) !!}">Word文档</a -->
																	<iframe src="http://docs.google.com/gview?url={!! asset('uploads/docs/'.$lesson[0]->attached_doc) !!}&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>
																	<br /><br />
																	@endif
																	@if( trim($lesson[0]->attached_pdf) )
																	<iframe src="http://docs.google.com/gview?url={!! asset('uploads/pdfs/'.$lesson[0]->attached_pdf) !!}&embedded=true" style="width:100%; height:600px;" frameborder="0"></iframe>
																	<br /><br />
																	@endif
																</div>
															</div>
														</div>
													</div>
													<hr class="uk-grid-divider">
													
												   
													 <div class="uk-grid" data-uk-grid-margin="">
														<div class="uk-width-medium-1-1">
															<p class="uk-text-primary uk-text-bold">作答：</p>

															@if( !count($selected_answer) )
															<form class="uk-form" method="post" enctype="multipart/form-data">
																{!! csrf_field() !!}
																<div class="uk-form-row">
																	<div class="uk-form-controls">
																		<ul class="uk-list">
																		@if( $lesson[0]->question_type == '單選題' )
																			<?php $i = 65; ?>
																			@forelse( $answers as $answer )
																			<li><label><span>&#{{ $i++ }};</span>) <input type="radio" name="selected_answer" value="{{ $answer->answer_code }}" /> <span>{{ $answer->answer }}</span></label></li>
																			<hr class="uk-grid-divider">
																			@empty
																			@endforelse
																		@endif

																		@if( $lesson[0]->question_type == '填充題' )
																			<li><input type="text" name="selected_answer" placeholder="輸入答案" value="{{ old('selected_answer') }}" required /></li>
																		@endif

																		@if( $lesson[0]->question_type == '問答題' )
																			<li><textarea cols="150" rows="5" name="selected_answer" placeholder="輸入答案" required>{{ old('selected_answer') }}</textarea></li>
																		@endif
																		</ul>
																	</div>
																</div>
																@if( $lesson[0]->question_type == '填充題' || $lesson[0]->question_type == '問答題' )
																<p>或是</p>
																<div class="uk-form-row">
																	<p class="uk-text-primary uk-text-bold">上傳圖片：</p>
																	<div class="uk-form-controls">
																		<div class="uk-form-file">
																			<button class="uk-button">選擇檔案</button>
																			<input type="file" name="answer_file" />
																		</div>
																	</div>
																</div>
																@endif

																<div class="uk-form-row">
																	<div class="uk-form-controls">
																		<button type="submit" class="uk-button uk-button-primary" data-message="答對了！恭喜您獲得923點積分。" data-status="success">送出</button>
																		<!-- <button class="uk-button uk-button-primary">送出</button> -->
																	</div>
																</div>
															</form>
															@else
															<div class="uk-form-row">
																<div class="uk-form-controls">
																	<button class="uk-button uk-button-primary" disabled>已作答</button>
																</div>
															</div>
															<a name="ans"></a>
															<hr class="uk-grid-divider">
															<p class="uk-text-primary uk-text-bold">正確答案：</p>
															<div class="uk-panel">
																<div class="uk-panel uk-panel-box">
																	@if( $lesson[0]->question_type == '單選題' )
																	<?php
																	$answer = DB::table('questions')->where('answer_code', $selected_answer[0]->selected_answer)->value('answer');
																	echo $answer;
																	?>
																	@else
																	<p>{{ $selected_answer[0]->selected_answer }}</p>
																	@endif

																	@if( $selected_answer[0]->answer_file )
																	<img src="{!! asset('uploads/sanswers/' .$selected_answer[0]->answer_file) !!}">
																	@endif
																</div>
															</div>
															@endif
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
@endsection