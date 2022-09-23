@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
<link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">

@endsection
@section('title', 'お題一覧')


@if($situation === "recruting")

    @section('header-title', '回答募集中のお題一覧')

@elseif($situation === "voting")

    @section('header-title', 'ナゲット受付中のお題一覧')

@elseif($situation === "finished")

    @section('header-title', '過去お題一覧')

@else

    @section('header-title', 'ファストマックのお題一覧')

@endif


@section('content')

<div class="situation-btns">
    <a href=" {{ url('/question_list?situation=recruting') }} " class="situation-btn"><button>募集中</button></a>
    <a href=" {{ url('/question_list?situation=voting') }} " class="situation-btn"><button>ナゲット</button></a>
    <a href=" {{ url('/question_list?situation=finished') }} " class="situation-btn"><button>過去お題</button></a>
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

    <form action=/question_list  method="post" enctype="multipart/form-data">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <input id="image" type="file" name="image">
        <button type="submit">送信</button>
        <input type="hidden" name="kind" value="0">
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif




<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@for($i=0; $i<$items->count(); $i++)
    <x-question :item='$items[$i]' :maker='$items[$i]->getMaker()' :likeUsers='$likeUsers[$i]["like"]'>
    </x-question>
@endfor

<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@endsection

@section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsers = <?php echo $jsonLikeUsers;?>;
    </script>
    <script src=" {{ asset('/js/QuestionLikeUserNames.js') }} "></script>
    @if(Auth::check())
        <script>
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src=" {{ asset('/js/like.js') }} "></script>
        <script src=" {{ asset('/js/addLikedClass.js') }} "></script>
    @endif
@endsection