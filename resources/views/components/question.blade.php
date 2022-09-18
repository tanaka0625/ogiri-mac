<div class="item question">
    <a href="/grouped_answer/{{$questionId}}" class="text"><h3>{{$text}}</h3></a>
    @if(!empty($imgName))
        <img src="/storage/question/{{$imgName}}" alt="" class="question-img">
    @endif
    <p class="info">作:<a href="/user/{{$userId}}">{{$maker}}</a> <span class="answer-number">{{$answerNumber}}回答</span> <span class="like">{{$like}}コーラ</span></p>
    <div class="like-user-names">
        @foreach($likeUsers as $likeUser)
        <a href="/user/{{$likeUser->id}}" class="like-user-name">{{$likeUser->name}}</a>
        @endforeach
    </div>
    <div class="question-footer">
        <p>{{$slot}}</p>
        <img class="like-btn" src="/images/icon/cola.png" alt="">
    </div>
</div>