@extends('layouts.app')

@section('fileLink')
@endsection
@section('title', 'お題一覧')


@if($situation === "recruting")

    @section('header-title', '回答募集中のお題一覧')

@elseif($situation === "voting")

    @section('header-title', 'ナゲット受付中のお題一覧')

@elseif($situation === "finished")

    @section('header-title', '過去お題一覧')

@else

    @section('header-title', 'ファストマックのお題一覧')

@endif


@section('content')

<div class="situation-btns">
    <button class="btn btn-dark" onclick="location.href=' {{ url('/question_list?situation=recruting') }} '">募集中</button>
    <button class="btn btn-dark" onclick="location.href=' {{ url('/question_list?situation=voting') }} '">ナゲット</button>
    <button class="btn btn-dark" onclick="location.href=' {{ url('/question_list?situation=finished') }} '">過去お題</button>
    <button class="btn btn-dark" onclick="location.href=' {{ url('/question_list?situation=fast') }} '">ファスト</button>
</div>

@if(Auth::user())
<div class="question_form">
    <h2>お題を投稿する</h2>
    
    @if(count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action=/question_list  method="post" enctype="multipart/form-data">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <input id="image" type="file" name="image">
        <button type="submit" class="btn btn-dark">送信</button>
        <input type="hidden" name="kind" value="0">
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

{{$questions->links()}}

<items-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsersList)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>

{{$questions->links()}}


@endsection

@section('script')
    @parent
@endsection