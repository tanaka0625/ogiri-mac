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
    @foreach($items as $item)

        @if($item->kind === 0 || $item instanceof App\Models\Question)
            @continue;
        @else
            <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :vote='$item->vote' :questionText='$item->getQuestionText()' :questionId='$item->getQuestionId()' :btnType='$btnType' :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id' :questionSituation='App\Models\Question::find($item->question_id)->getSituation()' :kind='$item->kind'>
                {{$item->created_at}}
            </x-answer>
        @endif
    @endforeach
</div>

<div class="late-answers">
    <h3>遅マック</h3>
    @foreach($items as $item)

        @if($item->kind != 0 || $item instanceof App\Models\Question)
            @continue;
        @else

            <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :vote='$item->vote' :questionText='$item->getQuestionText()' :questionId='$item->getQuestionId()' btnType="like" :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id' :questionSituation='App\Models\Question::find($item->question_id)->getSituation()' :kind='$item->kind'>
                {{$item->created_at}}
            </x-answer>
        @endif
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
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
    </script>
    <script src=" {{ asset('/js/add-won-class.js') }} "></script>
    <script src=" {{ asset('/js/AnswerLikeUserNames.js') }} "></script>
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