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
                        <li><a href="index.html">首頁</a></li>
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

							@include('shared.flasg_msgs')

                            <div class="uk-grid" data-uk-grid-margin="">
								<?php $active_tab = session('tab'); ?>
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="false"><a href="#"><i class="uk-icon-cloud-upload"> </i> 教材上傳</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br />

											<form class="uk-form uk-form-stacked" name="lessonx" method="post" enctype="multipart/form-data">
												{!! csrf_field() !!}

												<div class="uk-form-row">
													<label class="uk-form-label">類別</label>
													<div class="uk-form-controls">
														<select name="category" id="category">
															<option value="觀念"@if ($lesson[0]->category == '觀念') selected @endif>觀念</option>
															<option value="練習"@if ($lesson[0]->category == '練習') selected @endif>練習</option>
															<option value="批次上傳練習題"@if ($lesson[0]->category == '批次上傳練習題') selected @endif>批次上傳練習題</option>
														</select>
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">主題</label>
													<div class="uk-form-controls">
														<input type="text" name="topic_name" value="{{ $lesson[0]->topic_name }}" maxlength="255" placeholder="輸入主題名稱" class="uk-width-1-1" required />
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">內容</label>
													<div class="uk-form-controls">
														<!--textarea start-->
														<textarea name="description" data-uk-htmleditor="{mode:'tab'}">{{ $lesson[0]->description }}</textarea>
														<!--textarea end-->
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">影音連結</label>
													<div class="uk-form-controls">
														<input placeholder="貼上embed字串" class="uk-width-1-1" type="url" name="video_embed" value="{{ $lesson[0]->video_embed }}" />
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">Word 上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button>
															<input type="file" name="attached_doc" />
														</div>
														<span><a href="{!! url('uploads/docs/'.$lesson[0]->attached_doc) !!}">{{ $lesson[0]->attached_doc }}</a></span>
													</div>
												</div>

												<div class="uk-form-row">
													<label class="uk-form-label">PDF 上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button>
															<input type="file" name="attached_pdf" />
														</div>
														<span><a href="{!! url('uploads/pdfs/'.$lesson[0]->attached_pdf) !!}" target="_blank">{{ $lesson[0]->attached_pdf }}</a></span>
													</div>
												</div>

												<div class="uk-form-row question_section uk-hidden">
													<div class="uk-form-row">
														<label class="uk-form-label">題型</label>
														<div class="uk-form-controls">
															<select name="question_type" id="question_type">
																<option value="單選題"@if ($lesson[0]->question_type == '單選題') selected @endif>單選題</option>
																<option value="填充題"@if ($lesson[0]->question_type == '填充題') selected @endif>填充題</option>
																<option value="問答題"@if ($lesson[0]->question_type == '問答題') selected @endif>問答題</option>
															</select>
															<!-- a href="">＋ 新增選項</a -->
														</div>
													</div>

													<div class="uk-form-row multiple_choice_box">
														<div class="uk-form-controls">
															<ul class="uk-list multiple_choices">
																<?php $c = 'A'; ?>
																@forelse ($answers as $i => $answer)
																	<li>
																		<span>{{ $c++ }}</span> <input type="text" name="mc_answer[]" id="mc_answer_{{ $i }}" value="{{ $answer->answer }}" placeholder="輸入選項" />
																		&nbsp;&nbsp;&nbsp;&nbsp;
																		<label>正确答案 <input type="radio" name="correct"<?php echo $answer->correct == $answer->answer_code ? ' checked' : ''; ?> value="{{ $i }}" /></label>
																	</li>
																@empty
																	<li>
																		<span>A</span> <input type="text" name="mc_answer[]" id="mc_answer_0" placeholder="輸入選項" />
																		&nbsp;&nbsp;&nbsp;&nbsp;
																		<label>正确答案 <input type="radio" name="correct" value="1" /></label>
																	</li>
																@endforelse
															</ul>
															<a href="javascript:;" id="add_new_options">+ 新增選項</a>
														</div>
													</div>

													<div class="uk-form-row fill_in_blanks_box uk-hidden">
														<div class="uk-form-controls">
															<ul class="uk-list">
																<li><input type="text" name="fill_in_answer" id="fill_in_answer" value="<?php echo isset($answers[0]->answer) ? $answers[0]->answer : ''; ?>" placeholder="輸入答案" /></li>
															</ul>
														</div>
													</div>

													<div class="uk-form-row q_and_a_box uk-hidden">
														<div class="uk-form-controls">
															<ul class="uk-list">
																<li><textarea cols="150" name="qna_answer" id="qna_answer" rows="5" placeholder="輸入答案"><?php echo isset($answers[0]->answer) ? $answers[0]->answer : ''; ?></textarea></li>
															</ul>
														</div>
													</div>
												</div><br />

												<div class="uk-form-row">
													<div class="uk-form-controls">
														<button type="submit" class="uk-button uk-button-primary">儲存</button>
														<a href="{!! action('Teacher\TeacherController@lesson_list', [$alias]) !!}" class="uk-button uk-button-default">回去</a>
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
					$mc_count = <?php echo count($answers); ?>;

					$('#category').change( function() {
						if( $(this).val() == '練習' ) {
							$('#mc_answer_0').attr('required', true);
							$('.question_section').removeClass('uk-hidden');
						} else {
							$('#mc_answer_0').attr('required', false);
							$('.question_section').addClass('uk-hidden');
						}
					});
					$('#question_type').change( function() {
						$mc_count = 0;
						if( $('#category').val() != '練習' )	return false;		// if not 練習 then no changes needed

						if( $(this).val() == '單選題' ) {
							$('.multiple_choice_box').removeClass('uk-hidden');	$('#mc_answer_0').attr('required', true);
							$('.fill_in_blanks_box').addClass('uk-hidden');		$('#fill_in_answer').val('').attr('required', false);
							$('.q_and_a_box').addClass('uk-hidden');			$('#qna_answer').val('').attr('required', false);
						} else if( $(this).val() == '填充題' ) {
							$('.multiple_choice_box').addClass('uk-hidden');	$('.multiple_choices').empty().append('<li><span>A</span> <input type="text" name="mc_answer[]" id="mc_answer_0" placeholder="輸入選項"></li>');
							$('.fill_in_blanks_box').removeClass('uk-hidden');	$('#fill_in_answer').attr('required', true);
							$('.q_and_a_box').addClass('uk-hidden');			$('#qna_answer').val('').attr('required', false);
						} else if( $(this).val() == '問答題' ) {
							$('.multiple_choice_box').addClass('uk-hidden');	$('.multiple_choices').empty().append('<li><span>A</span> <input type="text" name="mc_answer[]" id="mc_answer_0" placeholder="輸入選項"></li>');
							$('.fill_in_blanks_box').addClass('uk-hidden');		$('#fill_in_answer').val('').attr('required', false);
							$('.q_and_a_box').removeClass('uk-hidden');			$('#qna_answer').attr('required', true);
						} 
					});
					$('#add_new_options').click( function() {
						// multiple_choices
						$start_index = 'A';	$mc_count++;
						$('.multiple_choices').append('<li><span>' +String.fromCharCode($start_index.charCodeAt(0) + $mc_count)+ '</span> <input type="text" name="mc_answer[]" id="mc_answer_' +$mc_count+ '" placeholder="輸入選項" required />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>正确答案 <input type="radio" name="correct" value="' +$mc_count+ '" /></label></li>');
					});
					$('.pagination').addClass('uk-pagination');

					// load question data
					$('#category').trigger('change');
					$('#question_type').trigger('change');
				});
				</script>
@endsection