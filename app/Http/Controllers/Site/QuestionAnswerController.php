<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\QuestionAnswer;
use App\Requests\WriteQuestionRequest;

class QuestionAnswerController extends Controller
{

    public function writeQuestion(WriteQuestionRequest $request)
    {
        $questionAnswer = QuestionAnswer::create($request->all());
        if($questionAnswer){
            $questionAnswer->delete();
            return $this->sendResponse(true);
        }
        return $this->sendResponse(false);
    }

}