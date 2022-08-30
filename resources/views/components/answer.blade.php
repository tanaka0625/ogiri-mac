<div class="item answer">

    <p class="vote-msg">※あなたがナゲットしました</p>
    <a href="/grouped_answer/{{$questionId}}" class="question-text">{{$questionText}}</a>
    <h3 class="text">{{$text}}</h3>
    <p class="info">作:<a class="maker" href="/user/{{$userId}}">{{$maker}}</a> <span class="like">{{$like}}ポテト</span></p>
    <div class="like-user-names">
        @foreach($likeUserNames as $likeUserName)
        <a href="/user/{{$userId}}" class="like-user-name">{{$likeUserName}}</a>
        @endforeach
    </div>


    <div class="answer-footer">
        <p>{{$slot}}</p>
        @if($questionSituation === 'voting')
        <img class="like-btn" src="/images/icon/chicken_nugget.png" alt="">
        @else
        <img class="like-btn" src="/images/icon/frenchfry.png" alt="">
        @endif
    </div>
    
</div>
