<!DOCTYPE html>
<html lang="zh-Hant" dir="ltr" class="uk-height-1-1 uk-notouch">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="shortcut icon"	href="{!! asset('img/logo.ico') !!}" type="image/x-icon" />
        <link rel="stylesheet"		href="{!! asset('css/uikit.css') !!}" />
        <link rel="stylesheet"		href="{!! asset('css/bqsh.css') !!}" />

        <script src="{!! asset('js/jquery.js') !!}"></script>
        <script src="{!! asset('js/uikit.min.js') !!}"></script>
    </head>

    <body>
		<div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
			@include('shared.header')
			@yield('content')
			@include('shared.footer')
		</div>
	</body>
</html>