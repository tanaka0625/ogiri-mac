@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/question.css') }} ">
<link rel="stylesheet" href="  {{ asset('/css/page-links.css') }}  ">

@endsection
@section('title', 'お題一覧')


@if($situation === "recruting")

    @section('header-title', '回答募集中のお題一覧')

@elseif($situation === "voting")

    @section('header-title', 'ナゲット受付中のお題一覧')

@elseif($situation === "finished")

    @section('header-title', '過去お題一覧')

@else

    @section('header-title', 'ファストマックのお題一覧')

@endif


@section('content')

<div class="situation-btns">
    <a href=" {{ url('/question_list?situation=recruting') }} " class="situation-btn"><button>募集中</button></a>
    <a href=" {{ url('/question_list?situation=voting') }} " class="situation-btn"><button>ナゲット</button></a>
    <a href=" {{ url('/question_list?situation=finished') }} " class="situation-btn"><button>過去お題</button></a>
    <a href=" {{ url('/question_list?situation=fast') }} " class="situation-btn"><button>ファスト</button></a>
</div>

@if(Auth::user())
<div class="question_form">
    <h2>お題を投稿する</h2>
    
    @if(count($errors) > 0)
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action=/question_list  method="post" enctype="multipart/form-data">
        @csrf
        <label for="text">お題</label>
        <textarea name="text" id="text" cols="30" rows="10"></textarea>
        <br>
        <input id="image" type="file" name="image">
        <button type="submit">送信</button>
        <input type="hidden" name="kind" value="0">
    </form>
</div>
@else
<p style="color: red;">お題・回答の投稿、ポテトにはログインが必要です。ログインにはメールアドレス等は必要ありません。</p>
@endif




<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    <items-question v-for="(item, index) in items" :key="item['question'].id" :item="item" :like-users="likeUsersList[index]"
    v-on:add-question-like="addQuestionLike" v-on:minus-question-like="minusQuestionLike"></items-qeustion>

<x-page url="question_list?situation={{$situation}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

@endsection

@section('script')
    @parent
    <script>
        let items = <?php echo $jsonItems;?>;
        let likeUsersList = <?php echo $jsonLikeUsersList;?>;
    </script>
    @if(Auth::check())
        <script>
            let user = <?php echo json_encode(Auth::user(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)?>;

        </script>
    @else
        <script>
            let user = "undefined";
        </script>
    @endif
    <script src=" {{ asset('/js/question.js') }} "></script>

    <script>

        let app = new Vue({

            el: ".content",
            data: {
                items: items,
                likeUsersList: likeUsersList
            },
            methods: {

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
                            
                            this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id == user.id),1);
                            
                        }
                    }
                }
            }
        })

    </script>
@endsection