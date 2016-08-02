@extends('master')
@section('title', '板橋高中雲端學習平台')

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
                        <input class="uk-width-2-5 uk-form-large" type="text" placeholder="Role Name" name="name" id="name" value="{{ old('name') }}" />
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="text" placeholder="display_name" name="display_name" id="display_name" />
                    </div>
                    <div class="uk-form-row">
                        <input class="uk-width-2-5 uk-form-large" type="text" placeholder="description" name="description" id="description" />
                    </div>
                    <div class="uk-form-row">
                        <button type="submit" class="uk-width-2-5 uk-button uk-button-danger uk-button-large">Submit</a>
                    </div>
                    
                </form>

            </div>
            <!-- content end-->

@endsection