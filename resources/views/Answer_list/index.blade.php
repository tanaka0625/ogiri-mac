@extends('layouts.app')

@section('fileLink')
<link rel="stylesheet" href=" {{ asset('/css/answer.css') }} ">
<link rel="stylesheet" href=" {{ asset('/css/page-links.css') }} ">
@endsection

@section('title', '回答一覧')

@section('header-title', '回答一覧')

@section('content')


    <x-page url="/answer_list?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>

    <div class="items-title">
        <h3>{{$itemsTitle}}</h3>
    </div>

    <div class="btns">
        @if($period === 'all')

            <a href=" {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} " class="period-btn"><button>月別</button></a>
            
        @else
            @if($period > '202110')
                <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$previousPeriod) }} "><button>1月前</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$nowPeriod) }} "><button>今月</button></a>
            @if($nowPeriod != $period)
                <a class="period-btn" href=" {{ url('/answer_list?order=' .$order. '&period=' .$nextPeriod) }} "><button>1月後</button></a>
            @endif
            <a class="period-btn" href=" {{ url('/answer_list?order=' .$order) }} "><button>全回答</button></a>
        @endif

        @if($order === 'like')
            <a class="order-btn" href=" {{ url('/answer_list?order=id&period=' .$period) }} "><button>新着順に並び替える</button></a>
        @else
            <a class="order-btn" href=" {{ url('/answer_list?order=like&period=' .$period) }} "><button>ポテト順に並び替える</button></a>
        @endif
    </div>

    <div class="itmes">

        <items-answer v-for="(item, index) in items" :key="item['answer'].id" :item="item" :like-users="likeUsersList[index]" btn-type="like" 
        v-on:add-answer-like="addAnswerLike" v-on:minus-answer-like="minusAnswerLike" v-on:add-vote="addVote" v-on:minus-vote="minusVote"></items-answer>

    </div>

    <x-page url="/answer_list?order={{$order}}&period={{$period}}" :pageLinks='$pageLinks' :maxPage='$maxPage' :page='$page'></x-page>


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
                            
                            this.likeUsersList[i]['like'].splice(likeUsers['like'].findIndex(element => element.id === user.id),1);
                            break;
                        }
                    }
                },
                addVote: function(likeUsers, user) {

                    for(let i=0; i<this.likeUsersList.length; i++){
                        
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


