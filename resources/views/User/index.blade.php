@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', 'ユーザー')

@section('header-title', $user->name)

@section('content')

<user-info v-if="{{Js::from($page)}} == 1" :user="{{Js::from($user)}}" :point="{{Js::from($point)}}" :avator-number="{{$avatorNumber}}"></user-info>

{{$paginator->links()}}

<div class="items-title">
    @if($category === 'post' && $order === 'created_at')
    <h3>新着順投稿</h3>
    @elseif($category === 'post' && $order === 'like')
    <h3>いいね順投稿</h3>
    @elseif($category === 'like' && $order === 'created_at')
    <h3>新着順いいね</h3>
    @elseif($category === 'like' && $order === 'like')
    <h3>いいね順いいね</h3>
    @endif
</div>

<div class="btns">
    @if($order === 'like')
        <button class="btn btn-dark" onclick="location.href=' {{ url('/user/' .$id. '?category=' .$category. '&order=created_at') }} '">新着順に並び替える</button>
    @else
        <button class="btn btn-dark" onclick="location.href=' {{ url('/user/' .$id. '?category=' .$category. '&order=like') }} '">いいねに並び替える</button>
    @endif
    @if($category === 'post')
        <button class="btn btn-dark" onclick="location.href=' {{ url('/user/' .$id. '?category=like&order=' .$order) }} '">いいね</button>
    @elseif($category === 'like')
        <button class="btn btn-dark" onclick="location.href=' {{ url('/user/' .$id. '?category=post&order=' .$order) }} '">投稿</button>
    @endif
</div>


<items-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsersList)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>


{{$paginator->links()}}

@section('script')
    @parent
@endsection

@endsection