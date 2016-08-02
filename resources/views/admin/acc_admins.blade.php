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
										<li class="uk-active" aria-expanded="true"><a href="#"><i class="uk-icon-list-alt"></i> 管理員列表</a></li>
										<li aria-expanded="false"><a href="#"><i class="uk-icon-plus-square-o"> </i> 增加名單</a></li>
									</ul>

									<ul id="switcher-content" class="uk-switcher">
										<li aria-hidden="true">
											<br />      
											<form class="uk-form">
												<input type="text" placeholder="輸入老師編號" class="uk-form-width-medium"> <button class="uk-button uk-button-primary" type="button" data-uk-button>搜尋</button>
											</form>
											<hr class="uk-grid-divider">
											<table class="uk-table uk-table-hover">
												<thead>
													<tr>
														<th>管理員帳號</th>
														<th>姓名</th>
													</tr>
												</thead>
												<tbody>
												@forelse( $admins as $admin )
													<tr>
														<td>a{{ ($admin->id < 10 ? '00' : ($admin->id < 100 ? '0' : '')).$admin->id }}</td>
														<td>{{ $admin->first_name.' '.$admin->last_name }}</td>
													</tr>
												@empty
												@endforelse
												</tbody>
											</table>
											<div class="uk-vertical-align uk-text-right uk-text-top">
												{!! $admins->render() !!}
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
																	<input type="hidden" name="user_role" value="3" />
																	<input class="uk-width-5-5 uk-form-large" type="text" name="first_name" placeholder="名字" value="{{ old('first_name') }}" required />
																	<input class="uk-width-5-5 uk-form-large" type="text" name="last_name" placeholder="姓" value="{{ old('last_name') }}" required />
																	<input class="uk-width-5-5 uk-form-large" type="email" name="email" placeholder="email" value="{{ old('email') }}" required />
																	<button type="submit" class="uk-width-2-5 uk-button uk-button-danger" style="float:right;">搜尋</button>
																</div>
															</form>
														</div>
													</div>
												</div>
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