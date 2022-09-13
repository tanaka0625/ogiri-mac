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
        @foreach($avators as $avator)
            <div class="avator">
                @if($avator === $user->avator)
                    <p class="msg">選択中です</p>
                @else
                    <p class="msg"></p>
                @endif

                <img src=" {{ asset('/images/' .$avator. '/' .$avator. '(75).png') }} " alt="">
                <button class="choice-btn">選択</button>
            </div>
        @endforeach
    </div>

@endsection

@section('script')
@parent
<script>
    avators = <?php echo json_encode($avators,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);?>;
    id = <?php echo Auth::user()->id;?>;
</script>
<script src=" {{ asset('/js/avator.js') }} "></script>

@endsection