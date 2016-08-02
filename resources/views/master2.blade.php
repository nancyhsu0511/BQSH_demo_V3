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

        <!-- Codemirror and marked dependencies -->
        <link rel="stylesheet" href="{!! asset('css/codemirror.css') !!}">
        <script src="{!! asset('js/codemirror.js') !!}"></script>
        <script src="{!! asset('js/markdown.js') !!}"></script>
        <script src="{!! asset('js/overlay.js') !!}"></script>
        <script src="{!! asset('js/xml.js') !!}"></script>
        <script src="{!! asset('js/gfm.js') !!}"></script>
        <script src="{!! asset('js/marked.js') !!}"></script>

        <!-- HTML editor CSS and JavaScript -->
        <link rel="stylesheet" href="{!! asset('css/htmleditor.css') !!}">
        <script src="{!! asset('js/htmleditor.js') !!}"></script>
        
        <!--TABLE SORTER START-->   

                <!-- jQuery: required (tablesorter works with jQuery 1.2.3+) -->
                <script src="{!! asset('js/jquery-1.2.6.min.js') !!}"></script>

                <!-- Pick a theme, load the plugin & initialize plugin -->
                <link href="{!! asset('css/theme.default.min.css') !!}" rel="stylesheet">
                <script src="{!! asset('js/jquery.tablesorter.min.js') !!}"></script>
                <script src="{!! asset('js/jquery.tablesorter.widgets.min.js') !!}"></script>
                <script>
                $(function(){
                    $('table').tablesorter({
                        widgets        : ['zebra', 'columns'],
                        usNumberFormat : false,
                        sortReset      : true,
                        sortRestart    : true
                    });
                });
                </script>
        <!--TABLE SORTER END-->
        <!--LIGHTBOX START-->
            <script src="{!! asset('js/lightbox/highlight.js') !!}"></script>
            <script src="{!! asset('js/lightbox/docs.js') !!}"></script>
            <script src="{!! asset('js/lightbox/modal.js') !!}"></script>
            <script src="{!! asset('js/lightbox/lightbox.js') !!}"></script>
        <!--LIGHTBOX END-->
    </head>

    <body>
		<div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
			@include('shared.header1')
			@yield('content')
			@include('shared.footer')
		</div>
	</body>
</html>