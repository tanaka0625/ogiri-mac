<a href=" {{ url($url) }} ">最初</a>
<a href=" {{ url($url. '&page=' .$previousPage) }} ">戻る</a>

@foreach($pageLinks as $pageLink)
    @if($page == $pageLink)
        <a class="now-page" href=" {{ url($url. '&page=' .$pageLink) }} ">{{$pageLink}}</a>
    @else
        <a href=" {{ url($url. '&page=' .$pageLink) }} ">{{$pageLink}}</a>
    @endif

@endforeach
<a href=" {{ url($url. '&page=' .$nextPage) }} ">次へ</a>
<a href=" {{ url($url. '&page=' .$maxPage) }} ">最後</a>