@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/battle.css') }} ">
@endsection

@section('title', 'ファストマック')

@section('header-title', 'ファストマック')

@section('content')

<button class="rule-btn">ルール</button>
<p id="rule-msg" class="off">
    回答時間2分→シェイク時間20秒で1位の回答を決めます。<br>
    1位になった人が次のお題を投稿します。1位になった人が60秒以内にお題を投稿しなかった場合お題を募集します。<br>
    回答は制限時間内なら何答でも出来ます。<br>
    時間内に3答以上回答が集まらない場合、もう一度2分間の回答時間となります。<br>
    シェイクが同数の場合、先に投稿された回答の勝利となります。
    <span class="rule-btn" style="color: blue">閉じる</span>

</p>

<p class="situation-msg"></p>

@if(!Auth::check())
    <p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<div id="question-form" class="off">
    <form action=/battle/addQuestion  method="post">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <button type="submit">送信</button>
        <input type="hidden" name="kind" value=1>
    </form>
</div>

<p class="time-msg"></p>

<div id="answer-form" class="off">
    <form action=/battle/addAnswer method="post">
        @csrf
        <label for="text">回答</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <input type="hidden" name='kind' value=2>
        <br>
        <button type="submit">送信</button>
    </form>
</div>

<p class="items-msg"></p>

<div class="items">
    
</div>

@endsection

@section('script')
    @parent
    @if(Auth::check())
        <script>
            userId = <?php echo Auth::user()->id;?>;
        </script>
    @endif
    <script src=" {{ asset('js/battle.js') }} "></script>
    <script src=" {{ asset('js/rule.js') }} "></script>
@endsection