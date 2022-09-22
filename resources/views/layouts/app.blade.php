<!DOCTYPE html>
<html lang="jn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta  name="viewport" content="width=device-width,initial-scale=1.0">

    <link rel="stylesheet" href=" {{ asset('/css/app.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/menu.css') }} ">
    <link rel="icon" href=" {{ asset('/images/icon/favicon.ico') }} " id="favicon">
    <link rel="apple-touch-icon" sizes="180x180" href=" {{ asset('/images/icon/apple-touch-icon-180x180.png') }} ">
    <link href="https://use.fontawesome.com/releases/v6.1.1/css/all.css" rel="stylesheet">

    @yield('fileLink')

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>


    
    <title>@yield('title')/大喜利マック</title>
</head>
<body>

    <div class="header">
        <div class="title">
            <h3>@yield('header-title')</h3>
        </div>

        <button class="menu-btn on">メニュー</button>

        <div class="menu">
            <p class="link-btn"><a href=" {{ url('/') }} " >トップ</a></p>
            <p class="link-btn"><a href=" {{ url('/answer_list') }} " >回答一覧</a></p>
            <p class="link-btn"><a href=" {{ url('/question_list') }} " >お題一覧</a></p>
            <p class="link-btn"><a href=" {{ url('/search') }} " >検索</a></p>
            <p class="link-btn"><a href=" {{ url('question_list?situation=recruting') }} ">回答する</a></p>
            <p class="link-btn"><a href=" {{ url('question_list?situation=voting') }} ">ナゲット</a></p>
            <p class="link-btn"><a href=" {{ url('/battle') }} ">ファスト</a></p>
            @if(Auth::check())
                <p class="link-btn"><a href=" {{ url('/logout') }} ">ログアウト</a></p>
                <p class="link-btn"><a href=" {{ url('/my_page') }} ">マイページ</a></p>
            @else
                <p class="link-btn"><a href=" {{ url('/login') }} ">ログイン</a></p>
            @endif
            <p class="link-btn"><a href=" {{ url('/rule') }} ">ルール</a></p>
            
            <p class="close">閉じる</p>
        </div>

        <p id="logined-user-cnt"></p>

    </div>

    <div id="container">

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <?php for($i=0; $i<2; $i++):?>
                <img src="/images/icon/hamburger.png" alt="">
                <img src="/images/icon/chicken_nugget.png" alt="">
                <img src="/images/icon/frenchfry.png" alt="">
                <img src="/images/icon/cola.png" alt="">
                <img src="/images/avator/avator(75).png" alt="">
            <?php endfor;?>

            <div>
                <a href="https://twitter.com/ogiri_battle" target="_blank" rel="noopener noreferrer">公式Twitter</a>
                <a href="https://twitter.com/tnk06250625" target="_blank" rel="noopener noreferrer">管理人のTwitter</a>
            </div>

            <?php for($i=0; $i<2; $i++):?>
                <img src="/images/icon/hamburger.png" alt="">
                <img src="/images/icon/chicken_nugget.png" alt="">
                <img src="/images/icon/frenchfry.png" alt="">
                <img src="/images/icon/cola.png" alt="">
                <img src="/images/avator/avator(75).png" alt="">
            <?php endfor;?>

        </div>

    </div>

    <div id="big-item-container" class="off">
        <div>
            <button class='close-btn'>×</button>
        </div>

        <div id="big-item"></div>
    </div>

    @section('script')
    <script src=" {{ asset('/js/menu.js') }} "></script>
    <script src=" {{ asset('/js/app.js') }} "></script>
    <script src=" {{ asset('/js/count-logined-user.js') }} "></script>

    @show

</body>
</html>