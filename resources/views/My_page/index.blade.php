@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href="  {{ asset('/css/answer.css') }}  ">
    <link rel="stylesheet" href="  {{ asset('/css/question.css') }}  ">
    <link rel="stylesheet" href="  {{ asset('/css/my-page.css') }}  ">
    <link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">
@endsection

@section('title', 'マイページ')

@section('header-title', 'マイページ')

@section('content')

@if($page == 1)
<div class="user-info">

    <a class="setting-btn" href=" {{ url('/setting') }} "><button>設定</button></a>

    <div class="avators">
        @for($i=0; $i < floor($point["total"]/300); $i++)
            <img class="avator" src=" {{ asset('/images/' .$user->avator. '/' .$user->avator. '(150).png') }} " alt="">
        @endfor

        <img src=" {{ asset('/images/' .$user->avator. '/' .$user->avator. '(' .$avatorNumber. ').png') }} " alt="" class="avator">
    </div>

    <p>体重: {{$point["total"]}}kg</p>
    <table>
        <tr>
            <td><img src=" {{ asset('/images/icon/frenchfry.png') }} " alt=""></td>
            <td>{{$point["answerLike"]}}kg</td>
        </tr>

        <tr>
            <td><img src=" {{ asset('/images/icon/chicken_nugget.png') }} " alt=""></td>
            <td>{{$point["vote"]}}kg</td>
        </tr>

        <tr>
            <td><img src=" {{ asset('/images/icon/shake.png') }} " alt=""></td>
            <td>{{$point["battleVote"]}}kg</td>
        </tr>

        <tr>
            <td><img src=" {{ asset('/images/icon/cola.png') }} " alt=""></td>
            <td>{{$point["questionLike"]}}kg</td>
        </tr>

        <tr>
            <td><img src=" {{ asset('/images/icon/hamburger.png') }} " alt=""></td>
            <td>{{$point["won"]}}kg</td>
        </tr>

        <tr>
            <td>所持金</td>
            <td>{{$user->energy}}円</td>
        </tr>
    </table>


    <div class="comment">
        <p>{{$user->comment}}</p>
    </div>
</div>
@endif

<x-page url="my_page?category={{$category}}&order={{$order}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

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

<p>test</p>

<div class="btns">

    @if($order === 'like')
        <a class="order-btn" href=" {{ url('my_page?category=' .$category. '&order=created_at') }} "><button>新着順に並び替える</button></a>
        @else
        <a class="order-btn" href=" {{ url('my_page?category=' .$category. '&order=like') }} "><button>いいね順に並び替える</button></a>
    @endif

    @if($category === 'post')
        <a href=" {{ url('/my_page?category=like&order=' .$order) }} " class="category-btn"><button>いいね</button></a>
    @elseif($category === 'like')
        <a href=" {{ url('/my_page?category=post&order=' .$order) }} " class="category-btn"><button>投稿</button></a>
    @endif

</div>




@for($i=0; $i<$items->count(); $i++)
    @if($items[$i] instanceof App\Models\Answer && $category === "like")

        <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType='like' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
            {{$items[$i]->created_at}}
        </x-answer>

    @elseif($items[$i] instanceof App\Models\Answer && $category === "post")

        <x-answer :item='$items[$i]' :maker='$items[$i]->getMaker()' :questionText='$items[$i]->getQuestionText()' btnType='delete' :likeUsers='$likeUsers[$i]["like"]' :voteUsers='$likeUsers[$i]["vote"]' :questionSituation='App\Models\Question::find($items[$i]->question_id)->getSituation()'>
            {{$items[$i]->created_at}}
        </x-answer>

    @else

        <x-question :text='$items[$i]->text' :maker='$items[$i]->getMaker()' :like='$items[$i]->like' :answerNumber='$items[$i]->answer_number' :imgName='$items[$i]->image_name' :questionId='$items[$i]->id' :userId='$items[$i]->user_id' :likeUsers='$likeUsers[$i]["like"]'>
            {{$items[$i]->created_at}}
        </x-question>
    @endif
@endfor

<x-page url="my_page?category={{$category}}&order={{$order}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsers = <?php echo $jsonLikeUsers;?>;
    </script>
    <script src="{{ asset('/js/AnswerLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/add-won-class.js') }} "></script>
    <script src="{{ asset('/js/QuestionLikeUserNames.js') }}"></script>
    <script src=" {{ asset('/js/big.js') }} "></script>

    @if(Auth::check())
        <script>
            let userId = "<?php echo Auth::user()->id;?>";
        </script>
        @if($category === "post")
        <script src=" {{ asset('/js/delete.js') }} "></script>
        @else
        <script src="{{ asset('/js/like.js') }}"></script>
        <script src="{{ asset('/js/addLikedClass.js') }}"></script>
        <script src="{{ asset('/js/addVoteMsg.js') }}"></script>
        @endif
    @endif
@endsection

@endsection