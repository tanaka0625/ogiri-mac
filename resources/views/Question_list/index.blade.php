@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
<link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">

@endsection
@section('title', 'お題一覧')

@section('header-title', 'お題一覧')

@section('content')

<div class="situation-btns">
    <a href=" {{ url('/question_list?situation=recruting') }} " class="situation-btn"><button>募集中</button></a>
    <a href=" {{ url('/question_list?situation=voting') }} " class="situation-btn"><button>ナゲット</button></a>
    <a href=" {{ url('/question_list?situation=finished') }} " class="situation-btn"><button>終マック</button></a>
    <a href=" {{ url('/question_list?situation=fast') }} " class="situation-btn"><button>ファスト</button></a>
</div>

@if(Auth::user())
<div class="question_form">
    <h2>お題を投稿する</h2>
    
    @if(count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action=/question_list  method="post">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <button type="submit">送信</button>
        <input type="hidden" name="kind" value="0">
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@foreach($items as $item)
    <x-question :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :answerNumber='$item->answer_number' :imgName='$item->image_name' :questionId='$item->id' :userId='$item->user_id' :likeUserNames='$item->getLikeUserNames()'>
        {{$item->created_at}}
    </x-question>
@endforeach

<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@endsection

@section('script')
    @parent
    <script src=" {{ asset('/js/QuestionLikeUserNames.js') }} "></script>
    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src=" {{ asset('/js/like.js') }} "></script>
        <script src=" {{ asset('/js/addLikedClass.js') }} "></script>
    @endif
@endsection