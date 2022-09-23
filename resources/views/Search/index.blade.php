@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="  {{ asset('/css/answer.css') }}  ">
<link rel="stylesheet" href="  {{ asset('/css/question.css') }}  ">
<link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">

@endsection

@section('title', '検索')

@section('header-title', '検索')

@section('content')

    <form action="/search" method="get" class="form">
        @csrf
        <p>検索したいキーワードを入力してください(※1単語)</p>
        <input type="search" name="keyWord" placeholder="キーワードを入力">
        <input type="submit" value="検索">
    </form>

    @if(!empty($keyWord))
        <p class="items-title">{{$keyWord}}の検索結果</p>
    @endif

    @if(!empty($keyWord))

        <x-page url="search?keyWord={{$keyWord}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

        <div class="items">

            @for($i=0; $i<$items->count(); $i++)

                @if($items[$i] instanceof App\Models\Answer)
                    <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType='like' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
                    </x-answer>
                @elseif($items[$i] instanceof App\Models\Question)
                    <x-question :item='$items[$i]' :maker='$items[$i]->getMaker()' :likeUsers='$likeUsers[$i]["like"]' :situation='$items[$i]->getSituation()'>
                    </x-question>
                @endif

            @endfor

            @if($page === 1)
                <div class="users">
                    <p>ユーザー</p>
                    @foreach($users as $user)
                        <p><a href=" {{ url('/user/' .$user->id) }} ">{{$user->name}}</a></p>
                    @endforeach
                </div>
            @endif

        </div>

        <x-page url="search?keyWord={{$keyWord}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    @endif
@endsection

@section('script')
@parent

@if(!empty($keyWord))
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsers = <?php echo $jsonLikeUsers;?>;
    
    </script>
    <script src="{{ asset('/js/AnswerLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/add-won-class.js') }} "></script>
    <script src="{{ asset('/js/QuestionLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/big.js') }} "></script>

    @if(Auth::check())
        <script>
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src="{{ asset('/js/like.js') }}"></script>
        <script src="{{ asset('/js/addLikedClass.js') }}"></script>
        <script src="{{ asset('/js/addVoteMsg.js') }}"></script>
    @endif
@endif
@endsection