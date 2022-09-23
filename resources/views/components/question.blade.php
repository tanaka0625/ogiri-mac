<div class="item question">
    <a href="/grouped_answer/{{$item->id}}" class="text"><h3>{{$item->text}}</h3></a>
    @if(!empty($item->image_name))
        <img src="/storage/question/{{$item->image_name}}" alt="" class="question-img">
    @endif
    <p class="info">作:<a href="/user/{{$item->user_id}}">{{$maker}}</a> <span class="answer-number">{{$item->answer_number}}回答</span> <span class="like">{{$item->like}}コーラ</span></p>
    <div class="like-user-names">
        @foreach($likeUsers as $likeUser)
        <a href="/user/{{$likeUser->id}}" class="like-user-name">{{$likeUser->name}}</a>
        @endforeach
    </div>
    <div class="question-footer">

        @if($situation === "recruting")
            <p>回答期限:{{$item->limit_answer}}</p>
        @elseif($situation === "voting")
            <p>ナゲット期限:{{$item->limit_vote}}</p>
        @else
            <p>{{$item->created_at}}</p>
        @endif
        
        <img class="like-btn" src="/images/icon/cola.png" alt="">
    </div>
</div>