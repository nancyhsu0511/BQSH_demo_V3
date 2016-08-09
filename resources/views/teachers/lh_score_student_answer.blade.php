@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:25px;padding-left:100px;">
					<b>答案:</b> 
					@if( count($answer) )
						<?php
						if( $lesson[0]->question_type == '單選題' ) {
							$answer_txt = DB::table('questions')->where('answer_code', $answer[0]->selected_answer)->value('answer');
						} else {
							$answer_txt = $answer[0]->selected_answer;
						}
						?>
						{{ $answer_txt }}<br />
						@if( $answer[0]->answer_file )
							<img src="{!! asset('uploads/sanswers/'.$answer[0]->answer_file) !!}" width="150" />
						@endif
					@endif
					<hr class="uk-grid-divider">
					<form class="uk-form" method="post">
						{!! csrf_field() !!}
						給分 <input type="number" min="0" max="{{ $lesson[0]->score }}" name="score" value="<?php echo (isset($score_received[0]->score) ? $score_received[0]->score : 0); ?>" placeholder="0" class="uk-form-width-mini" />&nbsp;/&nbsp;{{ $lesson[0]->score }}
						<button class="uk-button uk-button-primary" type="submit" data-uk-button>提交</button>
					</form>
					@if ( session('status') )
						<script>
							alert("{{ session('status') }}");
							parent.location.reload();
						</script>
					@endif
				</div>
@endsection