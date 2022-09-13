<div class="item answer">

    <p class="vote-msg">※あなたがナゲットしました</p>
    <a href=" {{ url('/grouped_answer/' .$questionId) }} " class="question-text">{{$questionText}}</a>
    <h3 class="text">{{$text}}</h3>
    <p class="info">作:<a class="maker" href=" {{ url('/user/' .$userId) }} ">{{$maker}}</a> <span class="like">{{$like}}ポテト</span> <span class="vote">{{$vote}}ナゲット</span></p>
    
    <div class="like-user-names">
        @foreach($likeUserNames as $likeUserName)
        <a href=" {{ url('/user/' .$userId) }} " class="like-user-name">{{$likeUserName}}</a>
        @endforeach
    </div>

    <div class="answer-footer">
        <p>{{$slot}}</p>
        @if($btnType === 'vote')
        <img class="vote-btn" src=" {{ asset('/images/icon/chicken_nugget.png') }} " alt="">
        @elseif($btnType === "like")
        <img class="like-btn" src=" {{ asset('/images/icon/frenchfry.png') }} " alt="">
        @elseif($btnType === "delete")
        <button class="delete-btn">削除</button>
        @endif
    </div>
    
</div>
