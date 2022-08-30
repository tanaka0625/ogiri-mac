@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href="/css/answer.css">
    <link rel="stylesheet" href="/css/question.css">
@endsection

@section('title', 'ユーザー')

@section('header-title', $user->name)

@section('content')

<a href="/user/{{$id}}/{{$category}}/{{$order}}/1">最初</a>
@foreach($pageLinks as $pageLink)
<a href="/user/{{$id}}/{{$category}}/{{$order}}/{{$pageLink}}">{{$pageLink}}</a>
@endforeach
<a href="/user/{{$id}}/{{$category}}/{{$order}}/{{$maxPage}}">最後</a>

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

<div class="order-btns">
    @if($order === 'like')
    <a class="order-btn" href="/user/{{$id}}/{{$category}}/created_at"><button>新着順に並び替える</button></a>
    @else
    <a class="order-btn" href="/user/{{$id}}/{{$category}}/like"><button>いいね順に並び替える</button></a>
    @endif
</div>

<div class="category-btns">
    @if($category === 'post')
    <a href="/user/{{$id}}/like/{{$order}}" class="category-btn"><button>いいね</button></a>
    @elseif($category === 'like')
    <a href="/user/{{$id}}/post/{{$order}}" class="category-btn"><button>投稿</button></a>
    @endif
</div>



@foreach($items as $item)
    @if($item instanceof App\Models\Answer)
    <x-answer :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :questionText='$item->getQuestionText() ' :questionId='$item->getQuestionId()' questionSituation='recruting' :likeUserNames='$item->getLikeUserNames()' :userId='$item->user_id'>
        {{$item->created_at}}
    </x-answer>
    @elseif($item instanceof App\Models\Question)
    <x-question :text='$item->text' :maker='$item->getMaker()' :like='$item->like' :answerNumber='$item->answer_number' :imgName='$item->image_name' :questionId='$item->id' :userId='$item->user_id' :likeUserNames='$item->getLikeUserNames()'>
        {{$item->created_at}}
    </x-question>
    @endif
@endforeach

<a href="/user/{{$id}}/{{$category}}/{{$order}}/1">最初</a>
@foreach($pageLinks as $pageLink)
<a href="/user/{{$id}}/{{$category}}/{{$order}}/{{$pageLink}}">{{$pageLink}}</a>
@endforeach
<a href="/user/{{$id}}/{{$category}}/{{$order}}/{{$maxPage}}">最後</a>

@section('script')
    <script src="/js/AnswerLikeUserNames.js"></script>
    <script src="/js/QuestionLikeUserNames.js"></script>

    @if(Auth::check())
        <script>
            let items = <?php echo $jsonItems;?>;
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        <script src="/js/like.js"></script>
        <script src="/js/addLikedClass.js"></script>
        <script src="/js/addVoteMsg.js"></script>

    @endif

@endsection




@endsection