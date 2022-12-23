@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', '検索')

@section('header-title', '検索')

@section('content')

    <form action="/search" method="get" class="form">
        @csrf
        <p>検索したいキーワードを入力してください(※1単語)</p>
        <input type="search" name="keyWord" placeholder="キーワードを入力">
        <button class="btn btn-dark" type="submit">検索</button>
    </form>

    @if(!empty($keyWord))
        <p class="items-title">{{$keyWord}}の検索結果</p>
    @endif

    @if(!empty($keyWord))

        {{$paginator->links()}}

        <items-list v-if="{{!empty($keyWord)}}" :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsersList)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>

        @foreach($users as $user)
            <p class="user-link"><a href=" {{ url('/user/' . $user->id) }} ">{{$user->name}}</a></p>
        @endforeach
        {{$paginator->links()}}

    @endif
@endsection

@section('script')
    @parent
@endsection