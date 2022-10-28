@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href=" {{ asset('/css/main.css') }} ">

@endsection

@section('title', '通知')

@section('header-title', '通知')

@section('content')

    <div class="items">

        <notices-list :items="{{Js::from($items)}}" :like-users-list="{{Js::from($likeUsersList)}}" :user="{{Js::from($user)}}"></notices-list>
    </div>


    @section('script')
    @parent

    <script src=" {{ asset('/js/big.js') }} "></script>

@endsection

@endsection