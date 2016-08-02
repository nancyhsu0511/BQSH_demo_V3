@extends('master_lbox')
@section('title', '設定答題時間：')

@section('content')
				<div class="uk-width-medium-1-1" style="position:relative;float:left;padding-top:100px;padding-left:80px;">
                    <form class="uk-form" method="post">
                        設定答題時間：
						{!! csrf_field() !!}
						<?php
						$mins = $secs = '';
						if( $lesson[0]->answer_mode_time ) {
							$tdata = json_decode($lesson[0]->answer_mode_time);
							$mins = $tdata->mins;
							$secs = $tdata->secs;
						}
						?>
						<input type="number" min="0" max="59" name="mins" value="{{ $mins }}" placeholder="1" class="uk-form-width-mini">&nbsp;分&nbsp;
						<input type="number" min="0" max="59" name="secs" value="{{ $secs }}" placeholder="0" class="uk-form-width-mini">&nbsp;秒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="uk-button uk-button-primary" type="submit" data-uk-button>發佈題目</button>
                        <br />
                    </form>
					@if ( session('status') )
						<script>alert("{{ session('status') }}");</script>
					@endif
				</div>
@endsection