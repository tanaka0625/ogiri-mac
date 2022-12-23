<!DOCTYPE html>
<html lang="jn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta  name="viewport" content="width=device-width,initial-scale=1.0">

    <link rel="stylesheet" href=" {{ mix('/css/app.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/main.css') }} ">
    <link rel="icon" href=" {{ asset('/images/icon/favicon.ico') }} " id="favicon">
    <link rel="apple-touch-icon" sizes="180x180" href=" {{ asset('/images/icon/apple-touch-icon-180x180.png') }} ">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">

    @yield('fileLink')

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>

    <title>@yield('title')/大喜利マック</title>
</head>
<body>
    <div id="app">
        <header-component title="@yield('header-title')" :my-user="{{ Js::from(Auth::user()) }}"></header-component>
        <div id="content">
            @yield('content')
            <footer-component></footer-component>
        </div>
    </div>
    @section('script')
    <script src=" {{ mix('/js/app.js') }} "></script>
    @show
</body>
</html>