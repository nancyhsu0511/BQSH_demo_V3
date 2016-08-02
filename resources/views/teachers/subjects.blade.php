@extends('master1')
@section('title', '板橋高中雲端學習平台')

@section('content')
            <!--content start-->
            <div class="uk-vertical-align uk-text-center">
                <!--SUBJECT-->
                <div class="uk-grid" data-uk-grid-margin="">
					@if(!$subjects->isEmpty())
						@foreach( $subjects as $subject )
                    <div class="uk-width-medium-1-3">
                        <figure class="uk-overlay uk-overlay-hover">
                            <a href="subject/{!! $subject->alias !!}">
                                <img src="{!! asset('img/'.$subject->img.'-on.png') !!}" width="241" height="240" alt="{!! $subject->name !!}">
                                <img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/'.$subject->img.'-off.png') !!}" width="241" height="240" alt="{!! $subject->name !!}">
                            <h3>{!! $subject->name !!}</h3></a>
                        </figure>
                    </div>
						@endforeach
					@endif
                </div>
                <!--SUBJECT-->
            </div>
            <!-- content end-->
@endsection