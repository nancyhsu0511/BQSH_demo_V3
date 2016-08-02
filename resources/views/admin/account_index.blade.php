@extends('master2')
@section('title', '板橋高中雲端學習平台')

@section('content')
                <div class="uk-width-medium-1-1">
                    <ul class="uk-breadcrumb">
                        <li><a href="{!! action('BaseController@index') !!}">首頁</a></li>
                        <li><a href="{!! action('BaseController@index') !!}">管理員登入</a></li>
                        <li><a href="{!! action('BaseController@index') !!}">管理功能</a></li>
                        <li class="uk-active"><span>帳號管理</span></li>
                    </ul>
                    <br />

					@include('shared.flasg_msgs')
					<div class="uk-grid" data-uk-grid-margin="">
						<div class="uk-width-medium-1-3">
							<a class="imgButton" href="{!! action('Admin\AdminController@acc_students') !!}"><img src="{!! asset('img/administer_management01.png') !!}" alt="學生設定"></a>
						</div>

						<div class="uk-width-medium-1-3">
							<a class="imgButton" href="{!! action('Admin\AdminController@acc_teachers') !!}"><img src="{!! asset('img/administer_management02.png') !!}" alt="老師設定"></a>

						</div>

						<div class="uk-width-medium-1-3">
							<a class="imgButton" href="{!! action('Admin\AdminController@acc_admins') !!}"><img src="{!! asset('img/administer_management03.png') !!}" alt="管理員設定"></a>
						</div>
					</div>
				</div>
@endsection