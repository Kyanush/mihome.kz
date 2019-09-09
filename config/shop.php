<?php
if(env('APP_NO_URL') == 'ShopX.kz')
{
    return [
        'attributes_path_file' => 'uploads/attributes/',
        'products_path_file' => 'uploads/products/',
        'carriers_path_file' => 'uploads/carriers/',
        'payments_path_file' => 'uploads/payments/',
        'categories_path_file' => 'uploads/categories/',
        'sliders_path_file' => 'uploads/sliders/',
        'news_path_file' => 'uploads/news/',

        'social_network' => [
            'instagram'       => 'https://www.instagram.com/shopx_kz',
            'instagram_token' => '4047447403.1677ed0.811d0cc4b3a241fc90598666d58fa709'
        ],

        'number_phones' => [
            [
                //'format' => '+7 (708) 961-92-25',
                //'number' => '+77089619225',
                'format' => '+7 (775) 108-03-90',
                'number' => '+77751080390',
                'contactType' => 'Менеджер'
            ]
        ],

        'address' => [
            [
                "streetAddress" => "Жибек Жолы 115, 3 этаж, офис 301/1",
                "addressLocality" => "г. Алматы",
                "postalCode" => "050004",
                "addressCountry" => "Казахстан",
                "working_hours" => "c 10:00 до 19:00 Без выходных!",
                "geo" => [
                    "latitude" => "43.261664",
                    "longitude" => "76.935906"
                ]
            ]
        ],

        'site_email' => 'shopx.kz@gmail.com',
        'logo'       => env('APP_URL') . '/site/images/shopx.kz/logo.png',
        'favicon'    => env('APP_URL') . '/site/images/shopx.kz/favicon.png'
    ];
}

if(env('APP_NO_URL') == 'Magazin-Xiaomi.kz')
{
    return [
        'attributes_path_file' => 'uploads/attributes/',
        'products_path_file' => 'uploads/products/',
        'carriers_path_file' => 'uploads/carriers/',
        'payments_path_file' => 'uploads/payments/',
        'categories_path_file' => 'uploads/categories/',
        'sliders_path_file' => 'uploads/sliders/',
        'news_path_file'    => 'uploads/news/',

        'social_network' => [
            'instagram'       => 'https://www.instagram.com/magazin_xiaomi_kz',
            'instagram_token' => '4047447403.1677ed0.811d0cc4b3a241fc90598666d58fa709'
        ],

        'number_phones' => [
            [
                //'format' => '+7 (708) 961-92-25',
                //'number' => '+77089619225',
                'format'      => '+7 (775) 108-03-90',
                'number'      => '+77751080390',
                'contactType' => 'Менеджер'
            ]
        ],

        'address' => [
            [
                "streetAddress" => "Жибек Жолы 115, 3 этаж, офис 301/1",
                "addressLocality" => "г. Алматы",
                "postalCode" => "050004",
                "addressCountry" => "Казахстан",
                "working_hours" => "c 10:00 до 19:00 Без выходных!",
                "geo" => [
                    "latitude" => "43.261664",
                    "longitude" => "76.935906"
                ]
            ]
        ],

        'site_email' => 'magazin-xiaomi.kz@gmail.com',
        'logo'    => env('APP_URL') . '/site/images/magazin-xiaomi.kz/logo.png',
        'favicon' => env('APP_URL') . '/site/images/magazin-xiaomi.kz/logo.png'
    ];
}

if(env('APP_NO_URL') == 'MiHome.kz')
{
    return [
        'attributes_path_file' => 'uploads/attributes/',
        'products_path_file' => 'uploads/products/',
        'carriers_path_file' => 'uploads/carriers/',
        'payments_path_file' => 'uploads/payments/',
        'categories_path_file' => 'uploads/categories/',
        'sliders_path_file' => 'uploads/sliders/',
        'news_path_file' => 'uploads/news/',

        'social_network' => [
            'instagram'       => 'https://www.instagram.com/mihome.kz',
            'instagram_token' => '4233405290.1677ed0.e5692138251945c9a0f76180a4885e49'
        ],

        'number_phones' => [
            [
                //'format' => '+7 (708) 961-92-25',
                //'number' => '+77089619225',
                'format' => '+7 (775) 108-03-90',
                'number' => '+77751080390',
                'contactType' => 'Менеджер'
            ]
        ],

        'address' => [
            [
                "streetAddress" => "Жибек Жолы 115, 3 этаж, офис 301/1",
                "addressLocality" => "г. Алматы",
                "postalCode" => "050004",
                "addressCountry" => "Казахстан",
                "working_hours" => "c 10:00 до 19:00 Без выходных!",
                "geo" => [
                    "latitude" => "43.261664",
                    "longitude" => "76.935906"
                ]
            ]
        ],

        'site_email' => 'info@mihome.kz',
        'logo' => env('APP_URL')    . '/site/images/mihome.kz/logo.png',
        'favicon' => env('APP_URL') . '/site/images/mihome.kz/favicon.png'
    ];
}
