@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="/css/answer.css">
<link rel="stylesheet" href="/css/question.css">
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
    @else
    （終マック）
    @endif
</h3>


<x-question :text='$question->text' :maker='$question->getMaker()' :like='$question->like' :answerNumber='$question->answer_number' :imgName='$question->image_name' :questionId='$question->id' :userId='$question->user_id' :likeUserNames='$question->getLikeUserNames()'>
    {{$question->created_at}}
</x-question>

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
        @if($questionSituation === 'recruti')
        <input type="hidden" name='kind' value=1>
        @else
        <input type="hidden" name='kind' value=0>
        @endif
        <br>
        <button type="submit">送信</button>
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<div class="entry-answers">
    <h3>エントリーマック</h3>
    @foreach($items as $item)

        @if($item->kind != 1 || $item instanceof App\Models\Question)
            @continue;
        @endif

        <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :questionText='$item->getQuestionText()' :questionId='$item->getQuestionId()' :questionSituation='$questionSituation' :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id'>
            {{$item->created_at}}
        </x-answer>
    @endforeach
</div>

<div class="late-answers">
    <h3>遅マック</h3>
    @foreach($items as $item)
    @if($item->kind != 0 || $item instanceof App\Models\Question)
        @continue
    @endif
    <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :questionText='$item->getQuestionText()' :questionId='$item->getQuestionId()' :questionSituation="$questionSituation" :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id'>
        {{$item->created_at}}
    </x-answer>
    @endforeach
</div>

<style>
    .question {
        margin-bottom: 50px;
    }

    .question-text {
        display: none;
    }
</style>


@endsection

@section('script')
    <script src="/js/AnswerLikeUserNames.js"></script>
    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
            let questionId = <?php echo $questionId;?>
        </script>

        @if($questionSituation === 'voting')
            <script src="/js/vote.js"></script>
        @else
            <script src="/js/like.js"></script>
        @endif

        <script src="/js/addLikedClass.js"></script>
        <script src="/js/addVoteMsg.js"></script>
    @endif
@endsection