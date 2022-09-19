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

            @foreach($items as $item)

                @if($item instanceof App\Models\Answer)
                    <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :vote='$item->vote' :questionText='$item->getQuestionText() ' :questionId='$item->getQuestionId()' btnType='like' :likeUsers='$item->getLikeUsers()' :userId='$item->user_id' :questionSituation='App\Models\Question::find($item->question_id)->getSituation()' :kind='$item->kind'>
                        {{$item->created_at}}
                    </x-answer>
                @elseif($item instanceof App\Models\Question)
                    <x-question :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :answerNumber='$item->answer_number' :imgName='$item->image_name' :questionId='$item->id' :userId='$item->user_id' :likeUsers='$item->getLikeUsers()'>
                        {{$item->created_at}}
                    </x-question>
                @endif

            @endforeach

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