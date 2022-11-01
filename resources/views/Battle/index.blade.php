@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', 'ファストマック')

@section('header-title', 'ファストマック')

@section('content')

<fast-page :my-user="{{Js::from(Auth::user())}}"></fast-page>
    
@endsection

@section('script')
    @parent

@endsection