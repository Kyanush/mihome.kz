<?php
namespace App\Services;

use App\Models\Callback;
use App\Models\Order;
use App\Models\TelegramBotUser;
use http\Env;
use Telegram\Bot\Api;
use App\Tools\Helpers;


class ServiceTelegram
{

    public $token, $site;

    public function __construct()
    {
        if(!$this->token)
            $this->token = env('TELEGRAM_BOT_TOKEN');

        $this->site = env('APP_URL');
    }

    public function get(){

        $telegram = new Api($this->token);
        $result   = $telegram->getWebhookUpdates();

        $text       = $result['message']['text']                ?? '';
        $chat_id    = $result['message']['chat']['id']          ?? '';
        $username   = $result['message']['from']['username']    ?? '';
        $first_name = $result['message']['from']['first_name']  ?? '';
        $last_name  = $result['message']['from']['last_name']   ?? '';

        if($text == '/start'){

            TelegramBotUser::updateOrCreate(
                ['chat_id' => $chat_id, 'site' => $this->site],
                [
                    'chat_id'    => $chat_id,
                    'username'   => $username,
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'site'       => $this->site
                ]
            );

            $reply = 'Ассалаумагалейкум!';
            $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply]);
        }

    }

    public function sendCallback($callback_id){
        $callback = Callback::find($callback_id);
        if(!$callback)
            return false;

        $text  = "\xE2\x9E\xA1 <a href='" . $callback->adminDetailUrl() ."'>№" . $callback->id . "</a>\n";

        $text .= "\xF0\x9F\x95\xA7 Время: " . date('d.m.Y H:i', strtotime($callback->created_at)) . "\n";
        $text .= "\xF0\x9F\x93\xA3 Тип: " . $callback->type . "\n";

        $text .= "\xE2\x98\x8E Мобильный телефон: <a href='tel:" . $callback->phone . "'>"   . $callback->phone . "</a>\n";
        $text .= "\xE2\x9C\x85 <a href='https://wa.me/" . Helpers::whatsAppNumber($callback->phone) . "?text=Здравствуйте'>Написать в WhatsApp</a>\n";

        if($callback->email)
            $text.= "\xE2\x9C\x89 Электронная почта: <a href='mailto:" . $callback->email . "'>"   . $callback->email . "</a>\n";

        $text .= "\xE2\x9E\xA1 <a href='" . $callback->url ."'>" . $callback->url . "</a>\n";

        if($callback->message)
            $text.= "\xE2\x98\x8E Сообщение: ". $callback->message . " \n";


        $telegram = new Api($this->token);
        $telegramBotUsers = TelegramBotUser::where('site', $this->site)->get();
        foreach ($telegramBotUsers as $user)
        {
            $telegram->sendMessage([ 'chat_id' => $user->chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $text ]);
        }

        return true;
    }

    public function sendOrder($order_id){

        $order = Order::find($order_id);
        if(!$order)
            return false;

        if($order->status_id == 1 or $order->status_id == 9)
        {
            $text  = "\xE2\x9E\xA1 <a href='" . $order->adminDetailUrl() ."'>№" . $order->id . "</a>\n";

            $text .= "\xF0\x9F\x92\x9A	Статус: " . $order->status->name . "\n";
            $text .= "\xF0\x9F\x95\xA7 Время: " . date('d.m.Y H:i', strtotime($order->created_at)) . "\n";
            $text .= "\xF0\x9F\x93\xA3 Тип заказа: " . $order->type->name . "\n";

            $text .= "\n";

            $telegram = new Api($this->token);


            foreach($order->products as $product){
                $text.= "\xF0\x9F\x94\xB4 <a href='" . $product->detailUrlProduct() . "'>" . $product->pivot->name . "</a>\n" .
                    "\xF0\x9F\x93\x8C Кол-во: " . $product->pivot->quantity . "\n" .
                    "\xF0\x9F\x92\xB2 Цена: "   . Helpers::priceFormat($product->pivot->price) . "\n" .
                    "\xF0\x9F\x92\xB8 Сумма: "  . Helpers::priceFormat($product->pivot->quantity * $product->pivot->price). "\n\n";
            }


            if($order->carrier)
            {
                $text.= "\xF0\x9F\x9A\x95 Доставка: " . $order->carrier->name . " - " . Helpers::priceFormat($order->carrier->price) . "\n";
            }
            if($order->payment)
            {
                $text.= "	\xF0\x9F\x92\xB3 Способ оплаты: " . $order->payment->name . "\n";
            }

            $text.= "\xF0\x9F\x92\xB0 Всего к оплате: <b>" . Helpers::priceFormat($order->total) . "</b>";

            $text.= "\n\n";

            $text.= "\xF0\x9F\x91\xA4 ФИО: " . $order->user_name . "\n";
            $text.= "\xE2\x98\x8E Мобильный телефон: <a href='tel:" . $order->user_phone . "'>"   . $order->user_phone . "</a>\n";
            $text.= "\xE2\x9C\x85 <a href='https://wa.me/" . Helpers::whatsAppNumber($order->user_phone) . "?text=Здравствуйте'>Написать в WhatsApp</a>\n";
            $text.= "\xE2\x9C\x89 Электронная почта: <a href='mailto:" . $order->user_email . "'>"   . $order->user_email . "</a>\n";

            if($order->city or $order->address)
                $text.= "\xF0\x9F\x9A\x95 Адрес доставки: {$order->city}, {$order->address}, <a target='_blank' href='https://2gis.kz/almaty/search/{$order->city}, {$order->address}'>2gis</a>\n";


            if($order->comment)
                $text.= "\xF0\x9F\x92\xAC Комментарий к заказу: " . $order->comment . "\n";

            if($order->comment_admin)
                $text.= "\xF0\x9F\x92\xAC Комментарии администратора: " . $order->comment_admin . "\n";

            $telegramBotUsers = TelegramBotUser::where('site', $this->site)->get();
            foreach ($telegramBotUsers as $user)
            {
                if($user->role == 'manager')
                    $telegram->sendMessage([ 'chat_id' => $user->chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $text ]);

                //Готов к отправке
                if($user->role == 'courier')
                    if($order->status_id == 9)
                        $telegram->sendMessage([ 'chat_id' => $user->chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $text ]);
            }

            return true;
        }

        return false;
    }

}