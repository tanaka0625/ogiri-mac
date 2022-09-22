@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', 'ランキング')

@section('header-title', 'ランキング')

@section('content')

<div id="users">

    @for($i=0; $i<$users->count(); $i++)

        <p class="user">{{$i+1}}位 <a href=" {{ url('/user/' .$users[$i]->id) }} ">{{$users[$i]->name}}</a> {{$users[$i]->user_point}}kg</p>

    @endfor


</div>



@endsection

@section('script')
@parent



@endsection