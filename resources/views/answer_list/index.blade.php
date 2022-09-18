@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/page-links.css') }} ">
@endsection

@section('title', '回答一覧')

@section('header-title', '回答一覧')

@section('content')

@php 
    echo 1;
@endphp


    <x-page url="/?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    <div class="items-title">
        <h3>{{$itemsTitle}}</h3>
    </div>

    <div class="btns">
        @if($period === 'all')

            <a href=" {{ url('/?order=' .$order. '&period=' .$nowPeriod) }} " class="period-btn"><button>月別</button></a>
            
        @else
            @if($period > '202110')
                <a class="period-btn" href=" {{ url('/?order=' .$order. '&period=' .$previousPeriod) }} "><button>1月前</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/?order=' .$order. '&period=' .$nowPeriod) }} "><button>今月</button></a>
            @if($nowPeriod != $period)
                <a class="period-btn" href=" {{ url('/?order=' .$order. '&period=' .$nextPeriod) }} "><button>1月後</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/?order=' .$order) }} "><button>全回答</button></a>
        @endif

        @if($order === 'like')
            <a class="order-btn" href=" {{ url('/?order=id&period=' .$period) }} "><button>新着順に並び替える</button></a>
        @else
            <a class="order-btn" href=" {{ url('/?order=like&period=' .$period) }} "><button>ポテト順に並び替える</button></a>
        @endif
    </div>

    <div class="itmes">
        @foreach($items as $item)
            <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :vote='$item->vote' :questionText='$item->getQuestionText() ' :questionId='$item->getQuestionId()' btnType='like' :likeUsers='$item->getLikeUsers()' :userId='$item->user_id' :questionSituation='App\Models\Question::find($item->question_id)->getSituation()' :kind='$item->kind'>
                {{$item->created_at}}
            </x-answer>
        @endforeach
    </div>

    <x-page url="?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>


@endsection

@section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
    </script>
    <script src="{{ asset('/js/AnswerLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/add-won-class.js') }} "></script>
    @if(Auth::check())
    <script>
        let userId = "<?php echo Auth::user()->id;?>";
    </script>

    <script src="{{ asset('/js/like.js') }}"></script>
    <script src="{{ asset('/js/addLikedClass.js') }}"></script>
    <script src="{{ asset('/js/addVoteMsg.js') }}"></script>
    @endif
@endsection


