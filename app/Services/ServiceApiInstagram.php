<?php
namespace App\Services;

class ServiceApiInstagram
{
    public $access_token = '';

    public function __construct($access_token = '')
    {
        if(!$access_token)
            $this->access_token = config('shop.social_network.instagram_token');
    }

    public function api($link){
        $instagram_cnct = curl_init(); // инициализация cURL подключения
        curl_setopt( $instagram_cnct, CURLOPT_URL, $link); // подключаемся
        curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
        curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
        $result = curl_exec( $instagram_cnct );
        curl_close( $instagram_cnct ); // закрываем соединение

        if($result)
        {
            $media = json_decode($result); // получаем и декодируем данные из JSON
            return $media->data ?? false;
        }

        return false;
    }

    public function data(){
        return $this->api("https://api.instagram.com/v1/users/self/media/recent/?access_token=" . $this->access_token);
    }

    public function userInfo(){
        return $this->api("https://api.instagram.com/v1/users/self/?access_token=" . $this->access_token);
    }

}
