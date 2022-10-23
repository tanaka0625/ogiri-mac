<div class="item answer" v-bind:class="{'liked-answer':isLiked({{$index}})}">

    @if($questionSituation === "finished" && $item->kind == 1)
        <p class="vote-msg" v-if="isVoted({{$index}})">※あなたがナゲットしました</p>
    @elseif($questionSituation === "voting" && $item->kind == 1)
        <p class="vote-msg" v-if="isVoted({{$index}})">※あなたがナゲットしました</p>
    @elseif($questionSituation === "fast" && $item->kind == 2)
        <p class="vote-msg" v-if="isVoted({{$index}})">※あなたがシェイクしました</p>
    @endif


    <a href=" {{ url('/grouped_answer/' .$item->question_id) }} " class="question-text">{{$questionText}}</a>
    @if(!empty(App\Models\Question::find($item->question_id)->image_name))
        <div class="img-container">
            <img src="/storage/question/{{App\Models\Question::find($item->question_id)->image_name}}" alt="" class="question-img">
        </div>
    @endif
    <h3 class="text">{{$item->text}}</h3>
    <p class="info">

        @if($questionSituation === "finished" && $item->kind === 1)

            <a class="maker" href=" {{ url('/user/' .$item->user_id) }} ">{{$maker}}</a> 
             <span class="like" v-on:click="activeLikeUsers({{$index}})">{{$item->like}}ポテト</span> 
             <span class="vote" v-on:click="activeVoteUsers({{$index}})">{{$item->vote}}ナゲット</span>

        @elseif($questionSituation === "fast" && $item->kind === 2)

            <a class="maker" href=" {{ url('/user/' .$item->user_id) }} ">{{$maker}}</a> 
             <span class="like" v-on:click="activeLikeUsers({{$index}})">{{$item->like}}ポテト</span> 
             <span class="vote" v-on:click="activeVoteUsers({{$index}})">{{$item->battle_vote}}シェイク</span>

        @elseif($item->kind === 0)

            <a class="maker" href=" {{ url('/user/' .$item->user_id) }} ">{{$maker}}</a> 
             <span class="like" v-on:click="activeLikeUsers({{$index}})">{{$item->like}}ポテト</span> 

        @endif
    </p>
    
    
    <div class="like-user-names" v-if="likeUserIndexes.includes({{$index}})">
        <p class="user-names-title">ポテトしたユーザー</p>
        @foreach($likeUsers as $likeUser)
        <a href=" {{ url('/user/' .$likeUser->id) }} " class="like-user-name">{{$likeUser->name}}</a>
        @endforeach
    </div>

    @if($questionSituation === "finished" && $item->kind === 1)

        <div class="vote-user-names" v-if="voteUserIndexes.includes({{$index}})">
            <p class="user-names-title">ナゲットしたユーザー</p>
            @foreach($voteUsers as $voteUser)
            <a href=" {{ url('/user/' .$voteUser->id) }} " class="vote-user-name">{{$voteUser->name}}</a>
            @endforeach
        </div>

    @elseif($questionSituation === "fast" && $item->kind === 2)

        <div class="vote-user-names" v-if="voteUserIndexes.includes({{$index}})">
            <p class="user-names-title">シェイクしたユーザー</p>
            @foreach($voteUsers as $voteUser)
            <a href=" {{ url('/user/' .$voteUser->id) }} " class="vote-user-name">{{$voteUser->name}}</a>
            @endforeach
        </div>

    @endif


    <div class="answer-footer">
        <p>{{$item->created_at}}</p>
        @if($btnType === 'vote')
        <img class="vote-btn" src=" {{ asset('/images/icon/chicken_nugget.png') }} " alt="">
        @elseif($btnType === "like")
        <img class="like-btn" src=" {{ asset('/images/icon/frenchfry.png') }} " alt="" v-on:click="like({{$index}})">
        @elseif($btnType === "delete")
        <button class="delete-btn">削除</button>
        @endif
    </div>
    
</div>
