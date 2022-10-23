@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
@endsection

@section('title', '回答')

@section('header-title', '回答')

@section('content')


<h3>
    お題
    @if($questionSituation === 'recruting')
    （回答募集中）
    @elseif($questionSituation === 'voting')
    （ナゲット受付中）
    @elseif($questionSituation === "fast")
    （ファストマック）
    @else
    （終マック）
    @endif
</h3>


<x-question :item='$question' :maker='$question->getMaker()' :like='$question->like' :likeUsers='$question->getLikeUsers()' :situation='$question->getSituation()'>
</x-question>

@if(Auth::user())
<div class="answer_form">
    <h2>回答する</h2>
    
    @if(count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action=/grouped_answer/{{$questionId}}  method="post">
        @csrf
        <label for="text">回答</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        @if($questionSituation === 'recruting')
        <input type="hidden" name='kind' value=1>
        @else
        <input type="hidden" name='kind' value=0>
        @endif
        <br>
        @if($questionSituation === "recruting" && Auth::user()->energy < 100)
        <p>お金が無いので回答できないよ💦ナゲットをすると200円貰えます</p>
        @else
        <button type="submit">送信</button>
        @endif
    </form>

    @if($questionSituation === "recruting")
    <p>あなたの所持金 {{Auth::user()->energy}}円</p>
    <p>このお題に回答すると100円消費します</p>
    @endif

</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif

<div class="entry-answers">
    <h3>エントリーマック</h3>
    <items-answer v-for="(item, index) in items" :key="item['answer'].id" :item="item" :like-users="likeUsersList[index]" btn-type="vote" 
    v-if="item['answer'].kind == 1 && item['question_situation'] === 'voting'" v-on:add-answer-like="addAnswerLike" v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote"></items-answer>

    <items-answer v-for="(item, index) in items" :key="item['answer'].id" :item="item" :like-users="likeUsersList[index]" btn-type="like" 
    v-if="item['answer'].kind == 1 && item['question_situation'] != 'voting'" v-on:add-answer-like="addAnswerLike" v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote"></items-answer>
</div>


<div class="late-answers">
    <h3>遅マック</h3>
    <items-answer v-for="(item, index) in items" :key="item['answer'].id" :item="item" :like-users="likeUsersList[index]" btn-type="like" 
    v-if="item['answer'].kind == 0" v-on:add-answer-like="addAnswerLike" v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote"></items-answer>
</div>



<!-- <style>
    .question {
        margin-bottom: 50px;
    }

    .question-text {
        display: none;
    }
</style> -->


@endsection

@section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsersList = <?php echo $jsonLikeUsers;?>;
    </script>
    <script src=" {{ asset('/js/big.js') }} "></script>

    @if(Auth::check())
        <script>
            let user = <?php echo json_encode(Auth::user(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)?>;
        </script>
    @else
        <script>
            let user = "undefined";
        </script>
    @endif

    <script src="{{ asset('/js/answer.js') }}"></script>

    <script>

        let app = new Vue({

            el: ".content",
            data: {
                items: items,
                likeUsersList: likeUsersList
            },
            methods: {

                addAnswerLike: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){
                        
                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['like'].push(user);
                        }
                    }
                },
                minusAnswerLike: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){

                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id == user.id),1);
                            
                        }
                    }
                },
                addVote: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){


                        // 他に投票してたら削除
                        for(let x=0; x<this.likeUsersList[i]['vote'].length; x++){

                            if(this.likeUsersList[i]['vote'][x].id === user.id){

                                this.likeUsersList[i]['vote'].splice(this.likeUsersList[i]['vote'].findIndex(element => element.id === user.id));

                            }
                        }
                        
                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['vote'].push(user);

                        }
                    }
                },
                minusVote: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){

                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['vote'].splice(likeUsers['vote'].findIndex(element => element.id == user.id),1);
                            
                        }
                    }
                }
            }
        })

    </script>

@endsection