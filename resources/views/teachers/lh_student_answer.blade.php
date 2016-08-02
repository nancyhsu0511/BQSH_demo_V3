@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:50px;padding-left:100px;">
					{{ $answer[0]->selected_answer }}<br />
					@if( $answer[0]->answer_file )
						<img src="{!! asset('uploads/sanswers/'.$answer[0]->answer_file) !!}" width="150" />
					@endif
				</div>
@endsection