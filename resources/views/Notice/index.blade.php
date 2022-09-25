@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/notice.css') }} ">

@endsection

@section('title', '通知')

@section('header-title', '通知')

@section('content')

    <div class="items">

        @for($i=0; $i<$items->count(); $i++)

            @if($items[$i] instanceof App\Models\Answer)

                <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType='like' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
                </x-answer>

            @elseif($items[$i] instanceof App\Models\Answer_like)

                <div class="item notice answer-like-notice">
                    <img src=" {{ asset('/images/icon/frenchfry.png') }} " alt="">

                    <div class="text-container">
                        <p><a href=" {{ url('/user/' .$items[$i]->user->id) }} ">{{$items[$i]->user->name}}</a> がポテトしました</p>
                        <a href=" {{ url('/grouped_answer/' .$items[$i]->answer->question_id) }} " class="text">{{$items[$i]->answer->text}}</a>
                    </div>

                </div>

            @elseif($items[$i] instanceof App\Models\Question_like)

                <div class="item notice question-like-notice">
                    <img src=" {{ asset('/images/icon/cola.png') }} " alt="">

                    <div class="text-container">
                        <p><a href=" {{ url('/user/' .$items[$i]->user->id) }} ">{{$items[$i]->user->name}}</a> がコーラしました</p>
                        <a href=" {{ url('/grouped_answer/' .$items[$i]->question->id) }} " class="text">{{$items[$i]->question->text}}</a>
                    </div>

                </div>


            @endif

        @endfor

    </div>


@section('script')
@parent


<script>
    let items = <?php echo $jsonItems;?>;
    let likeUsers = <?php echo $jsonLikeUsers;?>;

</script>
<script src="{{ asset('/js/AnswerLikeUserNames.js') }}"></script>
<script src=" {{ asset('/js/big.js') }} "></script>

@if(Auth::check())
    <script>
        let userId = "<?php echo Auth::user()->id;?>";
    </script>
    <script src="{{ asset('/js/like.js') }}"></script>
    <script src="{{ asset('/js/addLikedClass.js') }}"></script>
    <script src="{{ asset('/js/addVoteMsg.js') }}"></script>
@endif


@endsection

@endsection