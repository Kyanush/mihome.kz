<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 27.12.2018
 * Time: 17:23
 */

namespace App\Tools;

use App\Services\ServiceCity;

class Seo
{

    public static function main(){
        $city     = ServiceCity::getCurrentCity();

        $siteName = env('APP_NAME');

        $title       = "{$siteName} в {$city->name} - Электроника, Бытовая Техника, Смартфоны";
        $description = "{$siteName} — покупка бытовой техники и электроники ✅. Удобная процедура оформления ⭐, простой процесс покупки и большой ассортимент товаров ⚡. Описания товаров, отзывы и лучшие цены в Казахстане ☝.";
        $keywords    = "товары, НИЗКАЯ ЦЕНА, Скидки, Акции, {$siteName}, купить, бытовая техника, электроника, покупка";

        return [
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description
        ];
    }


    public static function productDetail($product, $category){

        $city     = ServiceCity::getCurrentCity();

        $siteName = env('APP_NAME');

        if($product->seo_keywords)
            $keywords = $product->seo_keywords;
        else
            $keywords =  "{$category->name}, {$product->name} , купить, НИЗКАЯ ЦЕНА, Скидки, Акции, {$siteName}, характеристики, описание, отзывы, рейтинг, цена, обзоры";

        if($product->seo_description)
            $description = $product->seo_description;
        else
            $description = "{$product->name} в {$city->name}, Казахстан. Сравнивайте цены всех продавцов ✅, читайте характеристики и отзывы покупаталей ⭐, покупайте по самым выгодным условиям ⚡, заказывайте доставку в любой город Казахстана ☝.";

        return [
            'title'       => "{$product->name} купить в {$city->name}, Казахстан",
            'keywords'    => $keywords,
            'description' => $description
        ];
    }


    public static function catalog($category){

        $keywords = $description = $title = 'Каталог товаров';


        if($category)
        {
            $city = ServiceCity::getCurrentCity();

            if($category->seo_keywords)
                $keywords = $category->seo_keywords;
            else
                $keywords =  "{$category->name}, купить, казахстан, цена, характеристики, отзывы, обзоры, доставка";

            if($category->seo_description)
                $description = $category->seo_description;
            else
                $description = "{$category->name} купить в {$city->name}, Казахстан ✅. Цены ⭐, характеристики ⚡, отзывы, обзоры, доставка ☝.";

            $title = "{$category->name} купить в {$city->name}, Казахстан";
        }

        return [
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description
        ];
    }

    public static function pageSeo($page = ''){

        $keywords = 'товары, НИЗКАЯ ЦЕНА, Скидки, Акции, ' . env('APP_NO_URL') . ' магазин электроники, купить, бытовая техника, электроника, покупка';

        $page_date = [
            'compare-products' => [
                'title'       => 'Сравнение товаров',
                'keywords'    => $keywords,
                'description' => env('APP_NO_URL') . ' – интернет-магазин мобильной и цифровой техники в Казахстане.'
            ],
            'contact' => [
                'title'       => 'Контакты',
                'keywords'    => $keywords,
                'description' => 'Контактные данные интернет магазина ' . env('APP_NO_URL') . ' в городе Алматы'
            ],
            'guaranty' => [
                'title'       => 'Гарантия',
                'keywords'    => $keywords,
                'description' => 'На тестирование товара и обнаружение брака Вам предоставляется 14 дней.При обнаружение брака вы обращаетесь к нам, и мы вместе ищем причину проблемы.'
            ],
            'delivery-payment' => [
                'title'       => 'Доставка, оплата',
                'keywords'    => $keywords,
                'description' => 'Стандартная курьерская доставка по г.Алматы – доставка по адресу, указанному при оформлении заказа. Доставка осуществляется в удобные для клиента время и день (с учетом рабочего времени основного склада), в том числе и в день оформления заказа, при наличии свободных курьеров и товара на складе.'
            ],
            'checkout' => [
                'title'       => 'Оформление заказа',
                'keywords'    => $keywords,
                'description' => env('APP_NO_URL') . ' – интернет-магазин мобильной и цифровой техники в Казахстане.'
            ],
            'about' => [
                'title'       => 'О нас',
                'keywords'    => $keywords,
                'description' => env('APP_NO_URL') . ' – интернет-магазин мобильной и цифровой техники в Казахстане.'
            ],
            'wishlist' => [
                'title'       => 'Мои закладки',
                'keywords'    => $keywords,
                'description' => env('APP_NO_URL') . ' – интернет-магазин мобильной и цифровой техники в Казахстане.'
            ]
        ];

        return $page ? $page_date[$page] : $page_date;
    }

}
