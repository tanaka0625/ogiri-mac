<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Answer_like;
use App\Library\Functions;


class Answer_listController extends Controller
{
    public function index(Request $request, $order='like', $period='all', $page=1) {

        $items = Answer::withInPeriod($period)->orderBy($order, 'desc')->offset(($page-1)*30)->limit(30)->get();

        if(Auth::check()){
            $items = Functions::judgeLiked($items, Auth::user()->id);
            $items = Functions::judgeVoted($items, Auth::user()->id);

        }


        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

        $makePageLinks = Functions::makePageLinks(Answer::withInperiod($period)->count(), $page);
        $pageLinks = $makePageLinks['pageLinks'];
        $maxPage = $makePageLinks['maxPage'];

        if($order === 'like' && $period === 'all'){
            $itemsTitle = 'ポテト順回答一覧';
        }elseif($order === 'id' && $period === 'all'){
            $itemsTitle = '新着順回答一覧';
        }elseif($order === 'like' && $period != 'all'){
            $itemsTitle = 'ポテト順' . mb_substr($period, 0, 4) . "年" . mb_substr($period, 4, 2) . "月の回答一覧";
        }elseif($order === 'id' && $period != 'all'){
            $itemsTitle = '新着順' . mb_substr($period, 0, 4) . "年" . mb_substr($period, 4, 2) . "月の回答一覧";
        }

        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'order' => $order, 
            'period' => $period, 
            'page' => $page,
            'itemsTitle' => $itemsTitle,
            'nowPeriod' => date('Ym'),
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage
        ];

        if($period != 'all') {
            $data['previousPeriod'] = $request->previousPeriod;
            $data['nextPeriod'] = $request->nextPeriod;
        }

        return view('Answer_list.index', $data);
    }
}
