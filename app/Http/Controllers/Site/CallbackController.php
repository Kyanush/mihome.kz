<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Callback;
use App\Models\Order;
use App\Requests\CallbackRequest;
use App\Requests\ContactRequest;
use App\Services\ServiceTelegram;
use Redirect;

class CallbackController extends Controller
{

    public function callback(CallbackRequest $request){

        $data = $request->all();

        //заказ
        $order = new Order();
        $order->type_id     = 6;
        $order->comment     = ($data['message'] ?? '') . ' ' . ($data['url'] ?? '');
        $order->user_email  = $data['email']   ?? '';
        $order->user_name   = $data['name']    ?? '';
        $order->user_phone  = $data['phone']   ?? '';
        if($order->save())
        {
            $serviceTelegram = new ServiceTelegram();
            $serviceTelegram->sendOrder($order->id);
        }

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