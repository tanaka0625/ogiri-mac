@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href=" {{ asset('/css/rule.css') }} ">
@endsection

@section('title', 'ルール')

@section('header-title', 'ルール')

@section('content')

<p>大喜利マックは大喜利をいっぱいすることでマック君を太らせてあげる大喜利サイトです。おもしろければおもしろいほどマック君が太っていく仕組みになっています。</p>

<p>長期戦と短期戦の2種類の大喜利を遊べます。</p>

<div class="rule">
    <button class="rule-btn">長期戦</button>
    <p class="rule-msg off">
        長期戦では回答期間4日間、ナゲット期間4日間の計8日間で1位の回答を決めます。<br>
        お題は誰でも投稿できます。<br>
        1人何回答でもできます。メニューの「回答する」から回答できます。ただし、1回答につき100円かかります。お金はナゲットをすることで200円稼ぐことができます。ナゲットはメニューの「ナゲット」からできます。<br>
        1位になったユーザーにはハンバーガーが与えられます。<br>
        回答期間を過ぎたお題にも回答できますが、「遅マック」となり、ナゲットの対象にはなりません。<br>
        <span class="rule-btn" style="color: blue">閉じる</span>

    </p>
</div>


<div class="rule">
    <button class="rule-btn">短期戦</button>
    <p class="rule-msg off">
        メニューの「ファスト」から飛べます。<br>
        回答時間2分→シェイク時間20秒で1位の回答を決めます。<br>
        1位になった人が次のお題を投稿します。1位になった人が60秒以内にお題を投稿しなかった場合お題を募集します。<br>
        回答は制限時間内なら何答でも出来ます。<br>
        時間内に3答以上回答が集まらない場合、もう一度2分間の回答時間となります。<br>
        シェイクが同数の場合、先に投稿された回答の勝利となります。<br>
        <span class="rule-btn" style="color: blue">閉じる</span>
    </p>
</div>


<table border="1">
    <tbody>

        <tr>
            <td>
                種類
            </td>
            <td>
                kg
            </td>
            <td>
                意味
            </td>
        </tr>

        <tr>
            <td>
                ポテト
            </td>
            <td>
                0.5kg
            </td>
            <td>
                回答へのいいね
            </td>
        </tr>

        <tr>
            <td>
                ナゲット
            </td>
            <td>
                1kg
            </td>
            <td>
                長期戦の投票
            </td>
        </tr>

        <tr>
            <td>
                シェイク
            </td>
            <td>
                1kg
            </td>
            <td>
                短期戦の投票
            </td>
        </tr>

        <tr>
            <td>
                コーラ
            </td>
            <td>
                1kg
            </td>
            <td>
                お題へのいいね
            </td>
        </tr>

        <tr>
            <td>
                ハンバーガー
            </td>
            <td>
                3kg
            </td>
            <td>
                長期戦の優勝特典
            </td>
        </tr>
    </tbody>
</table>

@endsection

@section('script')
@parent

    <script src=" {{ asset('/js/rule.js') }} "></script>


@endsection