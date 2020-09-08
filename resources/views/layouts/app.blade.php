<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="{!! asset('/css/app.css') !!}" type="text/css">
		<script type='text/javascript' src="{!! asset('/js/app.js') !!}"></script>
	</head>
    <body>
		@yield('content')
	</body>
</html>
