@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="/css/answer.css">
@endsection

@section('title', '回答一覧')

@section('header-title', '回答一覧')

@section('content')

    <a href="/items/{{$order}}/{{$period}}/1">最初</a>
    @foreach($pageLinks as $pageLink)
    <a href="/answer_list/{{$order}}/{{$period}}/{{$pageLink}}">{{$pageLink}}</a>
    @endforeach
    <a href="/answer_list/{{$order}}/{{$period}}/{{$maxPage}}">最後</a>




    <div class="items-title">
        <h3>{{$itemsTitle}}</h3>
    </div>

    <div class="period-btns">
        @if($period === 'all')
            <a href="/answer_list/{{$order}}/{{$nowPeriod}}/1" class="period-btn"><button>月別</button></a>
            
        @else
            @if($period > '202110')
                <a class="period-btn" href="/answer_list/{{$order}}/{{$previousPeriod}}/1"><button>1月前</button></a>
            @endif
            <a class="period-btn" href="/answer_list/{{$order}}/{{$nowPeriod}}/1"><button>今月</button></a>
            @if($nowPeriod != $period)
                <a class="period-btn" href="/answer_list/{{$order}}/{{$nextPeriod}}/1"><button>1月後</button></a>
            @endif
            <a class="period-btn" href="/answer_list/{{$order}}/all/1"><button>全回答</button></a>
        @endif
    </div>
    
    @if($order === 'like')
    <a class="order-btn" href="/answer_list/id/{{$period}}/1"><button>新着順に並び替える</button></a>
    @else
    <a class="order-btn" href="/answer_list/like/{{$period}}/1"><button>ポテト順に並び替える</button></a>
    @endif

    <div class="itmes">
        @foreach($items as $item)
            <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :questionText='$item->getQuestionText() ' :questionId='$item->getQuestionId()' questionSituation='recruting' :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id'>
                {{$item->created_at}}
            </x-answer>
        @endforeach
    </div>


    <a href="/answer_list/{{$order}}/{{$period}}/1">最初</a>
    @foreach($pageLinks as $pageLink)
    <a href="/answer_list/{{$order}}/{{$period}}/{{$pageLink}}">{{$pageLink}}</a>
    @endforeach
    <a href="/answer_list/{{$order}}/{{$period}}/{{$maxPage}}">最後</a>

@endsection

@section('script')


    <script src="/js/AnswerLikeUserNames.js"></script>
    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src="/js/like.js"></script>
        <script src="/js/addLikedClass.js"></script>
        <script src="/js/addVoteMsg.js"></script>

    @endif


@endsection

