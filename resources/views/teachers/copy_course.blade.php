@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:50px;padding-left:80px;">
                    <form class="uk-form" method="post">
						<h3>複製<span class="uk-text-primary uk-text-bold">「{{ $course[0]->course_name }}」</span>課程為</h3>
						<div class="uk-form-row">
							<span class="uk-text-bold">
								{!! csrf_field() !!}
								<input type="text" name="course_name" placeholder="新課程名稱" class="uk-form-width-medium" required />
								<button class="uk-button uk-button-primary" type="submit" data-uk-button>複製</button>
							</span>
						</div>
                    </form>
					@if ( session('status') )
						<script>alert("{{ session('status') }}");</script>
					@endif
				</div>
@endsection