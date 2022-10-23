@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
    <link rel="stylesheet" href=" {{ asset('/css/notice.css') }} ">

@endsection

@section('title', '通知')

@section('header-title', '通知')

@section('content')

    <div class="items">

        <div class="item-container" v-for="(item, index) in items" :key="item['key']">

            <items-answer :item="item" :like-users="likeUsersList[index]" btn-type="like" v-on:add-answer-like="addAnswerLike"
            v-on:minus-answer-like="minusAnswerLike" v-if="'answer' in item"></items-answer>

            <div class="item notice answer-like-notice" v-if="'answer_like' in item">
                <img src="/images/icon/frenchfry.png" alt="">
                <div class="text-container">
                    <p><a v-bind:href="'user/' + item['user'].id"><%item['user'].name%></a> がポテトしました</p>
                    <a v-bind:href="'grouped_answer/' + item['answer_question_id']" class="text"><%item['answer_text']%></a>
                </div>
            </div>
            
            <div class="item notice question-like-notice" v-if="'question_like' in item">
                <img src="/images/icon/cola.png" alt="">
                <div class="text-container">
                    <p><a v-bind:href="'user/' + item['user'].id"><%item['user'].name%></a> がコーラしました</p>
                    <a v-bind:href="'grouped_answer/' + item['question_like'].question_id" class="text"><%item['question_text']%></a>
                </div>
            </div>

        </div>
    </div>


    @section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsersList = <?php echo $jsonLikeUsersList;?>;
    </script>
    <script src=" {{ asset('/js/big.js') }} "></script>
    <script src=" {{ asset('/js/question.js') }} "></script>
    <script src="{{ asset('/js/answer.js') }}"></script>

    @if(Auth::check())
        <script>
            let user = <?php echo json_encode(Auth::user(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)?>;
        </script>
    @else
        <script>
            let user = "undefined";
        </script>
    @endif

    <script>
        let app = new Vue({

            el: ".content",
            data: {
                items: items,
                likeUsersList: likeUsersList
            },
            delimiters: ["<%","%>"],
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
                }
            }
        })
    </script>

@endsection

@endsection