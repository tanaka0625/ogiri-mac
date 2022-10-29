@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', '回答一覧')

@section('header-title', '回答一覧')

@section('content')

    {{$answers->links()}}

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

    <items-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsers)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>

    {{$answers->links()}}

@endsection

@section('script')
    @parent
    <script src=" {{ asset('/js/big.js') }} "></script>
@endsection


