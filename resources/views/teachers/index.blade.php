@extends('master1')
@section('title', '板橋高中雲端學習平台')

@section('content')
			<ul class="uk-breadcrumb">
				<li><a href="{!! action('Teacher\TeacherController@index') !!}">首頁</a></li>
				<li><a href="{!! action('Teacher\TeacherController@index') !!}">主题</a></li>
				<li class="uk-active"><span>{!! $subject->name !!}</span></li>
            </ul>
            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-4 uk-text-center">
                	<figure class="uk-overlay uk-overlay-hover">
                        <a href="{!! action('Teacher\TeacherController@lesson_list', $subject->alias) !!}">
                            <img src="{!! asset('img/teacher_menu-01-on.png') !!}" width="241" height="240" alt="備課專區">
                            <img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/teacher_menu-01-off.png') !!}" width="241" height="240" alt="備課專區">
                        <h3>備課專區</h3></a>
                    </figure>
                </div>

                <div class="uk-width-medium-1-4 uk-text-center">
                    <figure class="uk-overlay uk-overlay-hover">
                        <a href="{!! action('Teacher\TeacherController@teaching_zone', $subject->alias) !!}">
                            <img src="{!! asset('img/teacher_menu-02-on.png') !!}" width="241" height="240" alt="教學專區">
                            <img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/teacher_menu-02-off.png') !!}" width="241" height="240" alt="教學專區">
                        <h3>教學專區</h3></a>
                    </figure>
                </div>

                <div class="uk-width-medium-1-4 uk-text-center">
                    <figure class="uk-overlay uk-overlay-hover">
                        <a href="{!! action('Teacher\TeacherController@learning_history', $alias) !!}">
                            <img src="{!! asset('img/teacher_menu-03-on.png') !!}" width="241" height="240" alt="學習紀錄">
                            <img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/teacher_menu-03-off.png') !!}" width="241" height="240" alt="學習紀錄">
                        <h3>學習紀錄</h3></a>
                    </figure>
                </div>

                <div class="uk-width-medium-1-4 uk-text-center">
                    <figure class="uk-overlay uk-overlay-hover">
                        <a href="{!! action('Teacher\TeacherController@test_bank') !!}">
                            <img src="{!! asset('img/teacher_menu-04-on.png') !!}" width="241" height="240" alt="題庫管理">
                            <img class="uk-overlay-panel uk-overlay-image" src="{!! asset('img/teacher_menu-04-off.png') !!}" width="241" height="240" alt="題庫管理">
                        <h3>題庫管理</h3></a>
                    </figure>
                </div>
            </div>
@endsection