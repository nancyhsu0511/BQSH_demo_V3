@extends('master')
@section('title', 'Register')

@section('content')

			@foreach ($errors->all() as $error)
				<div class="uk-alert uk-alert-danger" data-uk-alert>
					<a href="" class="uk-alert-close uk-close"></a>
					<span>{{ $error }}</span>
				</div>
			@endforeach
			@if (session('status'))
				<div class="uk-alert uk-alert-success" data-uk-success>
					<a href="" class="uk-alert-close uk-close"></a>
					<span>{{ session('status') }}</span>
				</div>
			@endif

            <!--content start-->
            <div class="uk-vertical-align uk-text-center">
                <form class="uk-panel uk-form" method="post">

					{!! csrf_field() !!}

                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="text" name="first_name" placeholder="first name" value="{{ $user->first_name }}" required />
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="text" name="last_name" placeholder="last name" value="{{ $user->last_name }}" required />
                    </div>

                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="email" name="email" placeholder="email" value="{{ $user->email }}" />
                    </div>
                    <div class="uk-form-row">
                        <select class="uk-width-2-5 uk-form-large" name="role[]">
						@foreach( $roles as $role )
							<option value="{{ $role->id }}" @if( in_array($role->id, $selectedRoles) ) selected="selected" @endif>{!! $role->display_name !!}</option>
						@endforeach
						</select>
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="password" name="password" placeholder="密碼" />
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="password" name="password_confirmation" placeholder="密碼 confirm" />
                    </div>
                    <div class="uk-form-row">
                        <button type="submit" class="uk-width-2-5 uk-button uk-button-danger uk-button-large">登入</button>
                    </div>
                    
                </form>

            </div>
            <!-- content end-->

@endsection