@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="/css/question.css">
@endsection
@section('title', 'お題一覧')

@section('header-title', 'お題一覧')

@section('content')



<div class="situation-btns">
    <a href="/question_list/recruting/1" class="situation-btn"><button>募集中</button></a>
    <a href="/question_list/voting/1" class="situation-btn"><button>ナゲット</button></a>
    <a href="/question_list/finished/1" class="situation-btn"><button>終マック</button></a>
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

    <form action=/question_list  method="post">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <button type="submit">送信</button>
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<a href="/question_list/{{$situation}}/1">最初</a>
@foreach($pageLinks as $pageLink)
<a href="/question_list/{{$situation}}/{{$pageLink}}">{{$pageLink}}</a>
@endforeach
<a href="/question_list/{{$situation}}/{{$maxPage}}">最後</a>



@foreach($items as $item)
    <x-question :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :answerNumber='$item->answer_number' :imgName='$item->image_name' :questionId='$item->id' :userId='$item->user_id' :likeUserNames='$item->getLikeUserNames()'>
        {{$item->created_at}}
    </x-question>
@endforeach

<a href="/question_list/{{$situation}}/1">最初</a>
@foreach($pageLinks as $pageLink)
<a href="/question_list/{{$situation}}/{{$pageLink}}">{{$pageLink}}</a>
@endforeach
<a href="/question_list/{{$situation}}/{{$maxPage}}">最後</a>


@endsection

@section('script')
    <script src="/js/QuestionLikeUserNames.js"></script>

    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src="/js/like.js"></script>
        <script src="/js/addLikedClass.js"></script>

    @endif

@endsection

