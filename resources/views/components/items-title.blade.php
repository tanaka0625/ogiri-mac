<?php var_dump($order);?>


@if($order === 'like' && $period === 'all')
    <h3>ポテト順回答一覧</h3>
@elseif($order === 'id' && $period === 'all')
    <h3>新着順回答一覧</h3>
@elseif($order === 'like' && $period != 'all')
    <h3>ポテト順{{$period}}の回答一覧</h3>
@elseif($order === 'id' && $period != 'all')
    <h3>新着順{{$period}}の回答一覧</h3>
@else
    <p>{{$order}}</p>
@endif