@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', '設定')

@section('header-title', '設定')

@section('content')

    <setting-page :avators="{{Js::from($avators)}}" :my-user="{{Js::from(Auth::user())}}"></setting-page>

@endsection

@section('script')
@parent
@endsection