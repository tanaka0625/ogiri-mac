@extends('layouts.app')

@section('fileLink')
@endsection

@section('title', '設定')

@section('header-title', '設定')

@section('content')

    <setting-page :avators="{{Js::from($avators)}}" :user="{{Js::from($Iam)}}"></setting-page>

@endsection

@section('script')
@parent
@endsection