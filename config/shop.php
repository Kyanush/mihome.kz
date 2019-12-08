<?php
return [
    'attributes_path_file' => 'uploads/attributes/',
    'products_path_file'   => 'uploads/products/',
    'carriers_path_file'   => 'uploads/carriers/',
    'payments_path_file'   => 'uploads/payments/',
    'categories_path_file' => 'uploads/categories/',
    'sliders_path_file'    => 'uploads/sliders/',
    'news_path_file'       => 'uploads/news/',

    'social_network' =>
        [
            'instagram' => [
                'url'   => 'https://www.instagram.com/mihome.kz',
                'token' => '4233405290.1677ed0.e5692138251945c9a0f76180a4885e49',
                'icon'  => '/site/images/social-network/instagram.jpg',
                'title' => 'Вы в Instagram'
            ],
            'facebook' => [
                'url'   => 'https://web.facebook.com/mihome.kz',
                'icon'  => '/site/images/social-network/facebook.png',
                'title' => 'Вы в Facebook'
            ],
            'vk' => [
                'url'   => 'https://vk.com/mihome_kz',
                'icon'  => '/site/images/social-network/vk.png',
                'title' => 'Вы в Instagram'
            ],
            'yandex' => [
                'url'   => 'https://yandex.kz/profile/64393237639?lr=162',
                'icon'  => '/site/images/social-network/yandex.png',
                'title' => 'Вы в Yandex'
            ],
            'google' => [
                'url'   => 'https://www.google.kz/maps/place/MiHome+kz/@43.2616711,76.9359425,15z/data=!4m5!3m4!1s0x0:0x703fb3eb297a72d3!8m2!3d43.2616711!4d76.9359425?hl=ru-KZ',
                'icon'  => '/site/images/social-network/google.png',
                'title' => 'Вы в Google'
            ],
            '2gis' => [
                'url'   => 'https://2gis.kz/almaty/firm/70000001037819003',
                'icon'  => '/site/images/social-network/2gis.png',
                'title' => 'Вы в 2gis'
            ]
        ],

    'number_phones' => [
        [
            'format' => '+7 (775) 108-03-90',
            'number' => '+77751080390',
            'contactType' => 'Менеджер'
        ],
        [
            'format' => '+7 (707) 516-26-36',
            'number' => '+77075162636',
            'contactType' => 'Менеджер'
        ]
    ],

    'address' => [
        [
            "streetAddress" => "Жибек Жолы 115, 1 этаж, офис 122",
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
    'logo' => env('APP_URL')    . '/site/images/logo.png',
    'favicon' => env('APP_URL') . '/site/images/favicon.ico'
];
