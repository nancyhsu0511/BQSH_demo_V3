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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 老師列表</a></li>
										<li aria-expanded="false"><a href="#"><i class="uk-icon-plus-square-o"> </i> 增加名單</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form" method="post" action="{!! action('Admin\AdminController@search_teacher') !!}">
												{!! csrf_field() !!}
												<input type="text" name="keyw" placeholder="輸入老師編號" class="uk-form-width-medium" required />
												<button class="uk-button uk-button-primary" type="submit" data-uk-button>搜尋</button>
											</form>
											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>教師編號</th>
														<th>姓名</th>
														<th>email</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $teachers as $teacher )
													<tr>
														<td>t{{ ($teacher->id < 10 ? '00' : ($teacher->id < 100 ? '0' : '')).$teacher->id }}</td>
														<td>{{ $teacher->first_name.' '.$teacher->last_name }}</td>
														<td>{{ $teacher->email }}</td>
													</tr>
												@empty
												@endforelse
												</tbody>
											</table>
											<div class="uk-vertical-align uk-text-right uk-text-top">
												{!! $teachers->render() !!}
											</div>
										</li>
										<li class="uk-active" aria-hidden="false">
											<!--2nd TAB CONTENT START-->
											<br />
												<div class="uk-form-row">
													<label class="uk-form-label">手動新增</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<form class="uk-form" method="post">
																{!! csrf_field() !!}
																<div class="uk-form-row">
																	<input type="hidden" name="user_role" value="2" />
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
												<form method="post" enctype="multipart/form-data" accept-charset="UTF-8" action="{!! action('Admin\AdminController@import_csv') !!}">
													{!! csrf_field() !!}
													<div class="uk-form-row">
														<label class="uk-form-label">批次上傳</label>
														<div class="uk-form-controls">
															<div class="uk-form-file">
																<button class="uk-button">選擇檔案</button>
																<span class="uk-text-muted">（可匯入CSV表單）</span>
																<input type="file" name="import_csv" />
															</div>
														</div>
													</div>

													<div class="uk-form-row">
														<div class="uk-form-controls">
															<button class="uk-button uk-button-primary" type="submit">上傳</button>
														</div>
													</div>
												</form>

												<br /><br />
													<p class="uk-texxt-bold">格式範例：</p>
													<table class="uk-table">
														<thead>
															<tr>
																<th>教師編號</th>
																<th>姓名</th>
															</tr>
														</thead>
														<tr>
															<td>t001</td>
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