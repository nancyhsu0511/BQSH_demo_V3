@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('BaseController@index') !!}">管理員登入</a></li>
                        <li class="uk-active"><span>管理功能</span></li>
                    </ul>
                    <br />

					@include('shared.flasg_msgs')
					<div class="uk-grid" data-uk-grid-margin="">
						<div class="uk-width-medium-1-2 uk-text-center">
							<figure class="uk-overlay uk-overlay-hover">
								<a href="javascript:;" src="lesson_list.html">
									<img src="{!! asset('img/teacher_menu-02-on.png') !!}" alt="班級設定">
									<img src="{!! asset('img/teacher_menu-02-off.png') !!}" class="uk-overlay-panel uk-overlay-image" alt="班級設定">
									<h3>班級設定</h3>
								</a>
							</figure>
						</div>

						<div class="uk-width-medium-1-2 uk-text-center">
							<figure class="uk-overlay uk-overlay-hover">
								<a href="{!! action('Admin\AdminController@accounts') !!}">
									<img src="{!! asset('img/briefcase-on.png') !!}" alt="帳號管理">
									<img src="{!! asset('img/briefcase-off.png') !!}" class="uk-overlay-panel uk-overlay-image" alt="帳號管理">
									<h3>帳號管理</h3>
								</a>
							</figure>
						</div>
					</div>
				</div>
@endsection