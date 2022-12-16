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

            <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} '">月別</button>
            
        @else
            @if($period > '202110')
            <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=' .$order. '&period=' .$previousPeriod) }} '">1月前</button>
            @endif
            <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} '">今月</button>
            @if($nowPeriod != $period)
            <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=' .$order. '&period=' .$nextPeriod) }} '">1月後</button>
            @endif
            <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=' .$order) }} '">全回答</button>

        @endif

        @if($order === 'like')
        <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=id&period=' .$period) }} '">新着順に並び替える</button>
        @else
        <button class="btn btn-dark" onclick="location.href=' {{ url('/answer_list?order=like&period=' .$period) }} '">ポテト順に並び替える</button>
        @endif
    </div>

    <items-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsers)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>

    {{$answers->links()}}

@endsection

@section('script')
    @parent
@endsection


