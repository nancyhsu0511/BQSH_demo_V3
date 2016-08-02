@extends('master')
@section('title', '板橋高中雲端學習平台')

@section('content')

			@foreach ($errors->all() as $error)
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					<a href="" class="uk-alert-close uk-close"></a>
					<span>{{ $error }}</span>
				</div>
			@endforeach

            <!--content start-->
            <div class="uk-vertical-align uk-text-center">

                <form class="uk-panel uk-form" method="post">
					{!! csrf_field() !!}
                    <div class="uk-form-row">
						@if( Request::path() == 'login/student' )
							<img class="uk-margin-bottom" width="250" src="{!! asset('img/login_icon01.png') !!}" alt="">
						@elseif( Request::path() == 'login/teacher' )
							<img class="uk-margin-bottom" width="250" src="{!! asset('img/login_icon02.png') !!}" alt="">
						@elseif( Request::path() == 'login/admin' )
							<img class="uk-margin-bottom" width="250" src="{!! asset('img/login_icon03.png') !!}" alt="">
						@endif
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="text" placeholder="帳號" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="password" placeholder="密碼" name="password" />
                    </div>
                    <div class="uk-form-row">
                        <button type="submit" class="uk-width-2-5 uk-button uk-button-danger uk-button-large">登入</a>
                    </div>
                    <div class="uk-form-row uk-text-small uk-text-center">
                        <a class="uk-float-center uk-link uk-link-muted" href="">忘記密碼?</a>
                    </div>
                    
                </form>

            </div>
            <!-- content end-->

@endsection