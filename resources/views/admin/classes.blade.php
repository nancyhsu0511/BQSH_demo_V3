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
													<td>{{ $class->course_code }}</td>
													<td>{{ $class->course_name }}</td>
													<td><?php
													$count = DB::table('classes')->where('course_id', $class->id)->count();
													echo $count;
													?></td>
													<td>
														<a href="" class="uk-button uk-button-success" type="button" data-uk-button>編輯</a>
														<button class="uk-button uk-button-danger" type="button" data-uk-button>刪除</button>
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
											<form class="uk-form uk-form-stacked">
												<div class="uk-form-row">
													<label class="uk-form-label">手動新增</label>
													<div class="uk-form-controls">
														<div class="uk-form-file">
															<form class="uk-form">
															   <input type="text" placeholder="班級代號" class="uk-form-width-small"> 
															   <input type="text" placeholder="班級名稱" class="uk-form-width-small"> 
															   <input type="text" placeholder="班級人數" class="uk-form-width-small"> 
															   <button class="uk-button uk-button-primary" type="button" data-uk-button>新增</button>
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
				$('.pagination').addClass('uk-pagination');
				</script>
@endsection