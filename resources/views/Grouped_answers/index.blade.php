@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
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


<x-question :item='$question' :maker='$question->getMaker()' :like='$question->like' :likeUsers='$question->getLikeUsers()'>
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
        @if($questionSituation === 'recruting')
        <input type="hidden" name='kind' value=1>
        @else
        <input type="hidden" name='kind' value=0>
        @endif
        <br>
        @if($questionSituation === "recruting" && Auth::user()->energy < 100)
        <p>お金が無いので回答できないよ💦ナゲットをすると200円貰えます</p>
        @else
        <button type="submit">送信</button>
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

<div class="entry-answers">
    <h3>エントリーマック</h3>
    @for($i=0; $i<$items->count(); $i++)

        @if($items[$i]->kind === 0 || $items[$i] instanceof App\Models\Question)
            @continue;
        @else
            <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' :btnType='$btnType' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
            </x-answer>
        @endif
    @endfor
</div>

<div class="late-answers">
    <h3>遅マック</h3>
    @for($i=0; $i<$items->count(); $i++)

        @if($items[$i]->kind != 0 || $items[$i] instanceof App\Models\Question)
            @continue;
        @else

            <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType="like" :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
            </x-answer>
        @endif
    @endfor
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
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsers = <?php echo $jsonLikeUsers;?>;
    </script>
    <script src=" {{ asset('/js/add-won-class.js') }} "></script>
    <script src=" {{ asset('/js/AnswerLikeUserNames.js') }} "></script>
    <script src="{{ asset('/js/QuestionLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/big.js') }} "></script>

    @if(Auth::check())
        <script>
            let userId = "<?php echo Auth::user()->id;?>";
            let questionId = <?php echo $questionId;?>;
        </script>
        <script src=" {{ asset('/js/vote.js') }} "></script>
        <script src=" {{ asset('/js/like.js') }} "></script>
        <script src=" {{ asset('/js/addLikedClass.js') }} "></script>
        <script src=" {{ asset('/js/addVoteMsg.js') }}"></script>
    @endif
@endsection