<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Requests\CallbackRequest;
use App\Requests\ContactRequest;
use Redirect;

class CallbackController extends Controller
{

    public function callback(CallbackRequest $request){

        Callback::create([
            'phone' => $request->input('phone'),
            'type'  => 'Обратный звонок'
        ]);

        return $this->sendResponse(true);
    }

    public function contact(ContactRequest $request){
        Callback::create([
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'type'  => 'Написать руководителю'
        ]);

        return Redirect::back()->with('success', 'Спасибо! Ваше сообщение успешно отправлено. Наши менеджеры обязательно свяжутся с Вами и ответят на все Ваши вопросы.');
    }

}