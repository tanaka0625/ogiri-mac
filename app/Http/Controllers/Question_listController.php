<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Library\Functions;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddAnswerRequest;




class Question_listController extends Controller
{
    public function index(Request $request)
    {

        if(!empty($_GET['situation']))
        {
            $situation = $_GET['situation'];
        }else{
            $situation = "recruting";
        }

        if(!empty($_GET['page']))
        {
            $page = $_GET['page'];
        }else{
            $page = 1;
        }

        if($situation === 'recruting')
        {
            $items = Question::recruting()->orderBy('id', 'desc')->forpage($page, 30)->get();
            $makePageLinks = Functions::makePageLinks(Question::recruting()->count(), $page);


        }elseif($situation === 'voting')
        {
            $items = Question::voting()->orderBy('id', 'desc')->forpage($page, 30)->get();
            $makePageLinks = Functions::makePageLinks(Question::voting()->count(), $page);

        }elseif($situation === 'finished')
        {
            $items = Question::finished()->orderBy('id', 'desc')->forpage($page, 30)->get();
            $makePageLinks = Functions::makePageLinks(Question::finished()->count(), $page);

        }elseif($situation === "fast")
        {
            $items = Question::fast()->orderBy('id', 'desc')->forpage($page, 30)->get();
            $makePageLinks = Functions::makePageLinks(Question::fast()->count(), $page);

        }

        if(Auth::check()){
            $items = Functions::judgeLiked($items, Auth::user()->id);
        }

        $jsonItems = json_encode($items,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);



        $pageLinks = $makePageLinks['pageLinks'];
        $maxPage = $makePageLinks['maxPage'];

        $data = [
            'items' => $items,
            'jsonItems' => $jsonItems,
            'situation' => $situation,
            'page' => $page,
            'pageLinks' => $pageLinks,
            'maxPage' => $maxPage
        ];

        return view('Question_list.index', $data);
    }

    public function add(AddAnswerRequest $request)
    {

        if(!empty($request->file("image")))
        {
            $request->validate([
                'image' => 'max:1024|mimes:jpg,jpeg,png,gif'
            ]);

 

            $Question = new Question;
            $Question->text = $request->text;
            $Question->user_id = Auth::user()->id;
            $Question->kind = $request->kind;
            $Question->limit_answer = date('Y-m-d H:i:s', strtotime('+4day'));
            $Question->limit_vote = date('Y-m-d H:i:s', strtotime('+8day'));
            $Question->save();

            $extension = $request->file('image')->getClientOriginalExtension();
            $date = date('YmdHis');
            $request->file('image')->storeAs('public/questionImgs', $date . '.' . $Question->id . '.' . $extension);
            $Question->image_name = $date . '.' . $Question->id . '.' . $extension;
            $Question->save();

        }else{

            $Question = new Question;
            $Question->text = $request->text;
            $Question->user_id = Auth::user()->id;
            $Question->kind = $request->kind;
            $Question->limit_answer = date('Y-m-d H:i:s', strtotime('+4day'));
            $Question->limit_vote = date('Y-m-d H:i:s', strtotime('+8day'));
            $Question->save();

        }

        return redirect('/question_list');
    }
}
