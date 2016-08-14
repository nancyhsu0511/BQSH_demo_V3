@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('BaseController@index') !!}">管理員登入</a></li>
                        <li><span>班級設定</span></li>
                        <li class="uk-active"><span>班級列表</span></li>
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
								<div class="uk-width-medium-1-1">
									<ul class="uk-tab" data-uk-switcher="{connect:&#39;#switcher-content&#39;}">
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 班級列表</a></li>
										<li aria-expanded="false"><a href="#"><i class="uk-icon-plus-square-o"> </i> 新增班級</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form" method="post">
												{!! csrf_field() !!}
												<input type="text" name="class_code" placeholder="班級代號" class="uk-form-width-medium">
												<button class="uk-button uk-button-primary" type="submit" data-uk-button>搜尋</button>
											</form>
											<hr class="uk-grid-divider">

											<div class="uk-form-row editbox" style="display: none;">
												<a class="edit_cancel" style="float: right"><i class="uk-icon-times-circle"></i></a>
												<label class="uk-form-label">編輯類</label>
												<form id="cedit" class="uk-form uk-form-stacked" method="post" action="{!! action('Admin\AdminController@process_class') !!}">
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<form class="uk-form">
															   <input type="text" name="class_code" id="class_code" value="{{ old('class_code') }}" placeholder="班級代號" class="uk-form-width-small" required />
															   <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" placeholder="班級名稱" class="uk-form-width-small" required />
															   <input type="number" name="seats" id="seats" value="{{ old('seats') }}" placeholder="班級人數" min="1" max="100" class="uk-form-width-small" required />
															   <input type="hidden" name="class_id" id="class_id" value="0" />
															   <input type="hidden" name="act" value="edit" />
															   <button class="uk-button uk-button-primary" type="submit" data-uk-button>編輯</button>
															   {!! csrf_field() !!}
															</form>
														</div>
													</div>
												</form>
											</div>
											<hr class="uk-grid-divider edivider" style="display: none;">

											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>班級代號</th>
														<th>課程代號</th>
														<th>班級名稱</th>
														<th>人數</th>
														<th>設定</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $classes as $class )
												<tr>
													<td>c{{ ($class->id < 100 ? '0' : ($class->id < 10 ? '00' : '')).$class->id }}</td>
													<td>{{ $class->class_code }}</td>
													<td>{{ $class->class_name }}</td>
													<td>{{ $class->seats }}</td>
													<td>
														<button class="uk-button uk-button-success edit_class" data-ccode="{{ $class->class_code }}" data-cname="{{ $class->class_name }}" data-cid="{{ $class->id }}" data-seats="{{ $class->seats }}" type="button" data-uk-button>編輯</button>
														<button class="uk-button uk-button-danger del_class" data-ccode="{{ $class->class_code }}" data-cname="{{ $class->class_name }}" data-cid="{{ $class->id }}" data-seats="{{ $class->seats }}" type="button" data-uk-button>刪除</button>
													</td>
												</tr>
												@empty
												@endforelse
												</tbody>
											</table>
											<div class="uk-vertical-align uk-text-right uk-text-top">
												{!! $classes->render() !!}
											</div>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br />
											<div class="uk-form-row">
												<label class="uk-form-label">手動新增</label>
												<form class="uk-form uk-form-stacked" method="post" action="{!! action('Admin\AdminController@process_class') !!}">
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<form class="uk-form">
															   <input type="text" name="class_code" value="{{ old('class_code') }}" placeholder="班級代號" class="uk-form-width-small" required />
															   <input type="text" name="class_name" value="{{ old('class_name') }}" placeholder="班級名稱" class="uk-form-width-small" required />
															   <input type="number" name="seats" value="{{ old('seats') }}" placeholder="班級人數" min="1" max="100" class="uk-form-width-small" required />
															   <input type="hidden" name="act" value="add" />
															   <button class="uk-button uk-button-primary" type="submit" data-uk-button>新增</button>
															   {!! csrf_field() !!}
															</form>
														</div>
													</div>
												</form>
											</div>
											<hr class="uk-grid-divider">

											<form class="uk-form uk-form-stacked" method="post" enctype="multipart/form-data" accept-charset="UTF-8" action="{!! action('Admin\AdminController@import_class_csv') !!}">
												{!! csrf_field() !!}
												<div class="uk-form-row">
													<label class="uk-form-label">批次上傳</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<button class="uk-button">選擇檔案</button><span class="uk-text-muted">（可匯入CSV表單）</span>
															<input type="file" name="import_csv" />
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
																<th>班級代號</th>
																<th>班級名稱</th>
																<th>人數</th>
															</tr>
														</thead>
														<tr>
															<td>a001</td>
															<td>甲班</td>
															<td>31</td>
														</tr>
													</table>
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
				$(document).ready(function() {
					$('.pagination').addClass('uk-pagination');

					$('.edit_cancel').click( function() {
						$('#cedit')[0].reset();
						$('.editbox').hide(100);
						$('.edivider').hide(100);
					});
					$('.del_class').click( function() {
						if( confirm("Are you sure to delete this class?\n\n班級代號: " +$(this).attr('data-ccode')+ "\n班級名稱: " +$(this).attr('data-cname')+ "\n班級人數: " +$(this).attr('data-seats')) ) {
							window.location="{{ action('Admin\AdminController@delete_class', '') }}/" +$(this).attr('data-cid');
						}
						return false;
					});
					$('.edit_class').click( function() {
						$('#cedit')[0].reset();
						$('.editbox').show(100);
						$('.edivider').show(100);
						$('#class_code').val( $(this).attr('data-ccode') );
						$('#class_name').val( $(this).attr('data-cname') );
						$('#seats').val( $(this).attr('data-seats') );
						$('#class_id').val( $(this).attr('data-cid') );
					});
				});
				</script>
@endsection