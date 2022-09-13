@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/battle.css') }} ">
@endsection

@section('title', 'ファストマック')

@section('header-title', 'ファストマック')

@section('content')

<p class="situation-msg"></p>

<div id="question-form" class="off">
    <form action=/battle/addQuestion  method="post">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <button type="submit">送信</button>
        <input type="hidden" name="kind" value=1>
    </form>
</div>

<p class="time-msg"></p>

<div id="answer-form" class="off">
    <form action=/battle/addAnswer method="post">
        @csrf
        <label for="text">回答</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <input type="hidden" name='kind' value=2>
        <br>
        <button type="submit">送信</button>
    </form>
</div>

<p class="items-msg"></p>

<div class="items">
    
</div>

@endsection

@section('script')
    @parent
    @if(Auth::check())
        <script>
            userId = <?php echo Auth::user()->id;?>;
        </script>
    @endif
    <script src=" {{ asset('js/battle.js') }} "></script>
@endsection