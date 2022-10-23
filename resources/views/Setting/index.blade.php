@extends('layouts.app')

@section('fileLink')
    <link rel="stylesheet" href="{{ asset('/css/setting.css') }}">
@endsection

@section('title', '設定')

@section('header-title', '設定')

@section('content')

    <div class="form">
        <p>コメントを変更する</p>
        <form action="/setting/changeComment" method="post" class="form">
            @csrf
            <textarea name="comment" id="" cols="30" rows="10">{{$user->comment}}</textarea>
            <input type="submit" value="変更">
        </form>
    </div>

    <div class="avators">
        <p>アバター変更</p>
        <div class="avator" v-for="(avator, index) in avators" :key="avator">
            <p class="msg" v-if="user.avator === avator">選択中です</p>
            <img v-bind:src="'/images/' + avator + '/' + avator + '(75).png'" alt="">
            <button class="choice-btn" v-on:click="select(avator)">選択</button>
        </div>
    </div>

@endsection

@section('script')
@parent
<script>
    let avators = <?php echo json_encode($avators,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);?>;
    let user = <?php echo json_encode(Auth::user(),JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)?>;
</script>
<script>
    
    let app = new Vue({

        el: ".content",
        data: {
            avators: avators,
            user: user
        },
        methods: {
            select: function(avator){

                axios.post("/avator",{
                    id: this.user.id,
                    avator: avator
                })
                .then(function (response) {

                    this.user.avator = avator;

                }.bind(this))
                .catch(function (error){
                })
            }
        }
    });
    
</script>

@endsection