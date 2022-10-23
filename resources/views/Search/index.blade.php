@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href="  {{ asset('/css/answer.css') }}  ">
<link rel="stylesheet" href="  {{ asset('/css/question.css') }}  ">
<link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">

@endsection

@section('title', '検索')

@section('header-title', '検索')

@section('content')

    <form action="/search" method="get" class="form">
        @csrf
        <p>検索したいキーワードを入力してください(※1単語)</p>
        <input type="search" name="keyWord" placeholder="キーワードを入力">
        <input type="submit" value="検索">
    </form>

    @if(!empty($keyWord))
        <p class="items-title">{{$keyWord}}の検索結果</p>
    @endif

    @if(!empty($keyWord))

        <x-page url="search?keyWord={{$keyWord}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

        <div class="items">
            <div class="item-conteiner" v-for="(item, index) in items" :key="item.key">

                <items-answer :item="item" :like-users="likeUsersList[index]" btn-type="like" v-on:add-answer-like="addAnswerLike"
                v-on:minus-answer-like="minusAnswerLike" v-if="'answer' in item"></items-answer>

                <items-question :item="item" :like-users="likeUsersList[index]" v-if="'question' in item" v-on:add-question-like="addQuestionLike" 
                v-on:minus-question-like="minusQuestionLike"></items-qeustion>

            </div>

            <a class="user-link" v-for="(user, index) in users" :key="user.id" v-bind:href="'user/' + user.id"><%user.name%></a>

        </div>

        <x-page url="search?keyWord={{$keyWord}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    @endif
@endsection

@section('script')
    @parent
    @if(!empty($keyWord))
        <script>
            let items = <?php echo $jsonItems;?>;
            let likeUsersList = <?php echo $jsonLikeUsersList;?>;
            let users = <?php echo $users;?>;
        </script>
    @endif
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
                likeUsersList: likeUsersList,
                users: users
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
                },
                addQuestionLike: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){
                        
                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['like'].push(user);
                        }
                    }
                },
                minusQuestionLike: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){

                        if(likeUsers == this.likeUsersList[i]){
                            
                            this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id == user.id));
                            
                        }
                    }
                }
            }
        })

    </script>

@endsection