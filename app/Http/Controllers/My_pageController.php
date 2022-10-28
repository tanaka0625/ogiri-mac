<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library\Functions;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;


class My_pageController extends Controller
{

    public function index(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);


        if(!empty($_GET['category']))
        {
            $category = $_GET['category'];
        }else{
            $category = "post";
        }

        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }else{
            $order = "like";
        }

        if(!empty($_GET['page']))
        {
            $page = $_GET['page'];
        }else{
            $page = 1;
        }

        if(Auth::check())
        {
            $Iam = Auth::user();
        }else{
            $Iam = "undefined";
        }

        $user = User::find($id);
        $point = Functions::calculatePoint($id);
        if($user->user_point != $point["total"])
        {
            $user->user_point = $point["total"];
            $user->save();
        }

        // 300kg以外のアバター
        for($i=150; $point["total"] % 300 < $i * 2; $i--) {
            $avatorNumber = $i;
        }

        if($category === 'post')
        {
            $answers = $user->getAnswers();
            $questions = $user->getQuestions();

        }elseif($category === 'like')
        {
            $answers = $user->getLikedAnswers();
            $questions = $user->getLikedQuestions();
        }

        $answersPlusQuestions = $answers->merge($questions);


        if($order === 'created_at' && $category === 'post')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('created_at');
        }elseif($order === 'created_at' && $category === 'like')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('liked_at');
        }elseif($order === 'like')
        {
            $answersPlusQuestions = $answersPlusQuestions->sortByDesc('like');
        }


        $itemsIngredients = $answersPlusQuestions->forpage($page, 30)->values();

        $paginator = Functions::collectionToPaginator($itemsIngredients, $answersPlusQuestions->count(), 30, $page, "/my_page", ["order" => $order, "category" => $category]);

        $items = array();
        for($i=0; $i<$itemsIngredients->count(); $i++)
        {
            if($itemsIngredients[$i] instanceof Answer)
            {

                $items[$i] = [
                    'key' => $i,
                    'item_type' => "answer",
                    'content' => $itemsIngredients[$i],
                    'question_text' => $itemsIngredients[$i]->getQuestionText(),
                    'question_situation' => Question::find($itemsIngredients[$i]->question_id)->getSituation(),
                    'maker' => $itemsIngredients[$i]->user->name
                ];

            }elseif($itemsIngredients[$i] instanceof Question)
            {
                $items[$i] = [
                    'key' => $i,
                    'item_type' => "question",
                    'content' => $itemsIngredients[$i],
                    'maker' => $itemsIngredients[$i]->getMaker(),
                    'situation' => $itemsIngredients[$i]->getSituation()
                ];
            }
        }

        $likeUsersList = Functions::likeUsersList($itemsIngredients);
        
        $data = [
            'items' => $items,
            'itemsIngredients' => $itemsIngredients,
            'category' => $category,
            'order' => $order,
            'user' => $user,
            'id' => $id,
            'page' => $page,
            "point" => $point,
            "avatorNumber" => $avatorNumber,
            'likeUsersList' => $likeUsersList,
            'Iam' => $Iam,
            'paginator' => $paginator
            ];

        return view('My_page.index', $data);

    }
}
