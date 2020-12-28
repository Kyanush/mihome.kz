<?php

namespace App\Http\Controllers\WhatsApp;
use App\Http\Controllers\Admin\AdminController;

use App\Tools\Helpers;
use Illuminate\Http\Request;
use DB;

class WhatsAppController extends AdminController
{

    public $token = '0bgs6bdjq8mfvif4';

    public function dialogs(){
        $url = 'https://eu1.chat-api.com/instance154758/dialogs?token=' . $this->token;
        $result = @file_get_contents($url); // Отправим запрос
        $dialogs = json_decode($result, 1); // Разберем полученный JSON в массив

        return  $this->sendResponse($dialogs['dialogs']);
    }

    public function messages(Request $res)
    {

        $chat_id = $res->chat_id;
        $url = "https://eu1.chat-api.com/instance154758/messages?token={$this->token}&chatId=$chat_id";

        $result = @file_get_contents($url); // Отправим запрос
        $data = json_decode($result, 1); // Разберем полученный JSON в массив

        return  $this->sendResponse($data['messages']);
    }

    public function sendMessage(Request $res){

        $data = [
            'chatId' => $res->chat_id,
            'phone'  => $res->phone,
            'body'   => $res->message,
        ];


        $json = json_encode($data);

        $url = "https://eu1.chat-api.com/instance154758/message?token={$this->token}";

        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]
        ]);

        $result = @file_get_contents($url, false, $options);
        $data = json_decode($result, 1); // Разберем полученный JSON в массив
        return  $this->sendResponse($data);

    }

}
