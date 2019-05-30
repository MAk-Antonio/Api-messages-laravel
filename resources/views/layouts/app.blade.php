<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Docs</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="app">
    @include('templates.menu')
     <div class="container">
        @yield('content')
    </div>
</div>
</body>
</html>
