@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="  {{ asset('/css/answer.css') }}  ">
<link rel="stylesheet" href="  {{ asset('/css/question.css') }}  ">
@endsection

@section('title', '検索')

@section('header-title', '検索')

@section('content')


    <form action="" method="get" class="form">
        @csrf
        <p>検索したいキーワードを入力してください(※1単語)</p>
        <input type="search" name="keyWord" placeholder="キーワードを入力">
        <input type="submit" value="検索">
    </form>

    @if(!empty($keyWord))
        <p class="items-title">{{$keyWord}}の検索結果</p>
    @endif

    @if(!empty($keyWord))

        <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=1') }} ">最初</a>
        @foreach($pageLinks as $pageLink)
            <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=' .$pageLink) }} ">{{$pageLink}}</a>
        @endforeach
        <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=' .$maxPage) }} ">最後</a>


        <div class="items">

            @foreach($items as $item)

                @if($item instanceof App\Models\Answer)

                    <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :questionText='$item->getQuestionText() ' :questionId='$item->getQuestionId()' questionSituation='recruting' :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id'>
                        {{$item->created_at}}
                    </x-answer>

                @elseif($item instanceof App\Models\Question)

                    <x-question :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :answerNumber='$item->answer_number' :imgName='$item->image_name' :questionId='$item->id' :userId='$item->user_id' :likeUserNames='$item->getLikeUserNames()'>
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

        <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=1') }} ">最初</a>
        @foreach($pageLinks as $pageLink)
            <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=' .$pageLink) }} ">{{$pageLink}}</a>
        @endforeach
        <a href=" {{ url('/search?keyWord=' .$keyWord. '&page=' .$maxPage) }} ">最後</a>


    @endif



@endsection

@section('script')

@if(!empty($keyWord))
    <script src="{{ asset('/js/AnswerLikeUserNames.js') }}"></script>
    <script src="{{ asset('/js/QuestionLikeUserNames.js') }}"></script>
    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src="{{ asset('/js/like.js') }}"></script>
        <script src="{{ asset('/js/addLikedClass.js') }}"></script>
        <script src="{{ asset('/js/addVoteMsg.js') }}"></script>

        

    @endif
@endif


@endsection