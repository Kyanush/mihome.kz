<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 27.12.2018
 * Time: 17:23
 */

namespace App\Tools;


class Seo
{

    public static $city = 'Алматы, Казахстан';

    public static function main(){

        $title       = "MiHome (Ми Хоум) интернет-магазин в Алматы";
        $description = "Mihome ☝Xioami(Ксяоми) ☑МиХоум ☑Умный дом ☑Гаджеты ☝Новинки ⭐Оригинальный товар ✌Сервисная поддержка ⏳Акции";
        $keywords    = "Мой дом, менің үйім, сяоми, MiHome, Ми Хоум, xiaomi в казахстане, xiaomi казахстан, xiaomi купить в казахстане, xiaomi цена в казахстане, официальный магазин xiaomi в алматы, купить сяоми через интернет магазин, магазин xiaomi в алматы, магазин xiaomi, магазин xiaomi алматы, магазин ксиоми алматы";

        return [
            'title'       => $title,
            'keywords'    => $keywords,
            'description' => $description
        ];
    }


    public static function productDetail($product, $category){

        $city = self::$city;

        $siteName    = env('APP_NAME');
        $title       = $product->seo_title ? $product->seo_title : $product->name;
        $keywords    = "{$product->seo_keywords}, {$category->name}, {$product->name} , купить, НИЗКАЯ ЦЕНА, Скидки, Акции, {$siteName}, характеристики, описание, отзывы, рейтинг, цена, обзоры";

        $description = "{$product->seo_description}【{$product->name}】; Только оригинал ✅; Гарантия 1 год ☝ Бесплатная доставка по Алматы ✌ Скидки и подарки ⭐; Адрес: Жибек Жолы 115. Доставка в Астану 1 ⚡ рабочий день. Доставка по Казахстану 1 ⚡ рабочих дня в Шымкент, Караганда, Актобе, Тараз, Павлодар, Усть-Каменогорск, Семей, Уральск, Костанай, Атырау, Кызылорда, Петропавловск, Актау, Кокшетау, Экибастуз";

        return [
            'title'       => "{$title} цена, купить в {$city}",
            'keywords'    => $keywords,
            'description' => $description
        ];
    }


    public static function catalog($category){

        $keywords = $description = $title = 'Каталог товаров';


        if($category)
        {
            $city = self::$city;

            $keywords    = $category->seo_keywords ? $category->seo_keywords . ', ' : '';
            $keywords    = "{$keywords}{$category->name} купить в $city, купить, казахстан, цена, характеристики, отзывы, обзоры, доставка";

            $description = "{$category->seo_description}【{$category->name}】; Только оригинал ✅; Гарантия 1 год ☝ Бесплатная доставка по Алматы ✌ Скидки и подарки ⭐; Адрес: Жибек Жолы 115. Доставка в Астану 1 ⚡ рабочий день. Доставка по Казахстану 1 ⚡ рабочих дня в Шымкент, Караганда, Актобе, Тараз, Павлодар, Усть-Каменогорск, Семей, Уральск, Костанай, Атырау, Кызылорда, Петропавловск, Актау, Кокшетау, Экибастуз";

            $title = $category->seo_title ? $category->seo_title : $category->name;
            $title = "{$title} цена, купить в $city";
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
            'compare_products' => [
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
            'delivery_payment' => [
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
            ],
            'electricScooterService' => [
                'title'       => 'Ремонт электросамокатов и гироскутеров в Алматы',
                'description' => 'Компания специализируется на оказании услуг по ремонту и обслуживание самокатов в Алматы',
                'keywords'    => 'запчасти на самоката xiaomi, ремонт самокат xiaomi, ремонт самокатов xiaomi, аксессуары для самоката xiaomi, ремонт электросамокатов xiaomi, запчасти для самоката xiaomi, запчасти на электросамокат xiaomi, xiaomi m365 запчасти, запчасти самокат xiaomi, замена камеры на самокате xiaomi, xiaomi mijia m365 запчасти, ремонт электросамоката xiaomi, xiaomi m365 замена камеры, самокат xiaomi запчасти, электросамокат xiaomi запчасти, xiaomi самокат запчасти, ремонт xiaomi самокат, запчасти для xiaomi mijia m365'
            ],
            'cashback' => [
                'title'       => 'Кэшбэк за отзыв',
                'keywords'    => '',
                'description' => 'Возвращайте часть стоимости от товара! Напишите отзыв и делитесь впечатлениями с друзьями в Instagram. Что необходимо сделать? Приобрести товар в нашем магазине MiHome.kz (@mihome.kz). Сделать на него обзор или отзыв (желательно видео). Разместить п...'
            ],
        ];

        return $page ? $page_date[$page] : $page_date;
    }

}
