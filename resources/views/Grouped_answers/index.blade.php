@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', '回答')

@section('header-title', '回答')

@section('content')


<h3>
    お題
    @if($questionSituation === 'recruting')
    （回答募集中）
    @elseif($questionSituation === 'voting')
    （ナゲット受付中）
    @elseif($questionSituation === "fast")
    （ファストマック）
    @else
    （終マック）
    @endif
</h3>

<items-list :items="{{Js::from($questionList)}}" :like-users-list="{{Js::from($questionLikeUsersList)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>


@if(Auth::user())
<div class="answer_form">
    <h2>回答する</h2>
    
    @if(count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action=/grouped_answer/{{$questionId}}  method="post">
        @csrf
        <label for="text">回答</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        @if($questionSituation === 'recruting')
        <input type="hidden" name='kind' value=1>
        @else
        <input type="hidden" name='kind' value=0>
        @endif
        <br>
        @if($questionSituation === "recruting" && Auth::user()->energy < 100)
        <p>お金が無いので回答できないよ💦ナゲットをすると200円貰えます</p>
        @else
        <button type="submit" class="btn btn-dark">送信</button>
        @endif
    </form>

    @if($questionSituation === "recruting")
    <p>あなたの所持金 {{Auth::user()->energy}}円</p>
    <p>このお題に回答すると100円消費します</p>
    @endif

</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<p>エントリーマック</p>
<items-list :items="{{Js::from($items1)}}" :like-users-list="{{Js::from($likeUsersList1)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="{{$btnType}}"></items-list>

<p>遅マック</p>
<items-list :items="{{Js::from($items2)}}" :like-users-list="{{Js::from($likeUsersList2)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>



@endsection

@section('script')
    @parent
@endsection