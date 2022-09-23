@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/page-links.css') }} ">
@endsection

@section('title', '回答一覧')

@section('header-title', '回答一覧')

@section('content')

    <x-page url="/answer_list?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    <div class="items-title">
        <h3>{{$itemsTitle}}</h3>
    </div>

    <div class="btns">
        @if($period === 'all')

            <a href=" {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} " class="period-btn"><button>月別</button></a>
            
        @else
            @if($period > '202110')
                <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$previousPeriod) }} "><button>1月前</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} "><button>今月</button></a>
            @if($nowPeriod != $period)
                <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$nextPeriod) }} "><button>1月後</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/answer_list?order=' .$order) }} "><button>全回答</button></a>
        @endif

        @if($order === 'like')
            <a class="order-btn" href=" {{ url('/answer_list?order=id&period=' .$period) }} "><button>新着順に並び替える</button></a>
        @else
            <a class="order-btn" href=" {{ url('/answer_list?order=like&period=' .$period) }} "><button>ポテト順に並び替える</button></a>
        @endif
    </div>

    <div class="itmes">
        @for($i=0; $i<$items->count(); $i++)
            <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType='like' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
            </x-answer>
        @endfor
    </div>

    <x-page url="/answer_list?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>


@endsection

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


