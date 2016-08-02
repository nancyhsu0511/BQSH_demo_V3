@extends('master')
@section('title', '板橋高中雲端學習平台')

@section('content')

            <div class="uk-grid" data-uk-grid-margin="">
                <div class="uk-width-medium-1-3">
                	<a class="imgButton" href="login/student"><img src="img/student_login_pic.png" alt="學生登入"></a>
                </div>

                <div class="uk-width-medium-1-3">
                    <a class="imgButton" href="login/teacher"><img src="img/teacher_login_pic.png" alt="老師登入"></a>

                </div>

                <div class="uk-width-medium-1-3">
					<a class="imgButton" href="login/admin"><img src="img/admin_login_pic.png" alt="管理員登入"></a>
                </div>
            </div>

@endsection
