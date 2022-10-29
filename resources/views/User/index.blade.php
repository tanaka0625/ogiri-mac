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
    <a class="order-btn" href=" {{ url('/user/' .$id. '?category=' .$category. '&order=created_at') }} "><button>新着順に並び替える</button></a>
    @else
    <a class="order-btn" href=" {{ url('/user/' .$id. '?category=' .$category. '&order=like') }} "><button>いいね順に並び替える</button></a>
    @endif

    @if($category === 'post')
    <a href=" {{ url('/user/' .$id. '?category=like&order=' .$order) }} " class="category-btn"><button>いいね</button></a>
    @elseif($category === 'like')
    <a href=" {{ url('/user/' .$id. '?category=post&order=' .$order) }} " class="category-btn"><button>投稿</button></a>
    @endif

</div>


<items-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsersList)}}" :my-user="{{Js::from(Auth::user())}}" answer-btn-type="like"></items-list>


{{$paginator->links()}}

@section('script')
    @parent
    <script src=" {{ asset('/js/big.js') }} "></script>
@endsection

@endsection