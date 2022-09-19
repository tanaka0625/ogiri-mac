@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href=" {{ asset('css/top.css') }} ">
@endsection

@section('title', '店頭')

@section('header-title', '店頭')

@section('content')

<div class="avator">
    <p class="avator-comment">
        こんなガリガリじゃはずかしいよ…
    </p>
    <img src=" {{ asset('/images/avator/avator(1).png') }} " alt="">
</div>

<p>大喜利をいっぱいして、デブにしてあげよう！</p>

<div class="imgs">
    <img src="/images/icon/hamburger.png" alt="">
    <img src="/images/icon/chicken_nugget.png" alt="">
    <img src="/images/icon/frenchfry.png" alt="">
    <img src="/images/icon/cola.png" alt="">
    <img src="/images/icon/shake.png" alt="">
    <img src="/images/icon/hamburger.png" alt="">
    <img src="/images/icon/chicken_nugget.png" alt="">
    <img src="/images/icon/frenchfry.png" alt="">
    <img src="/images/icon/cola.png" alt="">
    <img src="/images/icon/shake.png" alt="">
</div>


<div class="avator">
    <p class="avator-comment">
        ありがと
    </p>
    <img src=" {{ asset('/images/avator/avator(150).png') }} " alt="">
</div>


@endsection

@section('script')
@parent


@endsection