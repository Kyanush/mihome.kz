<?php
/**
 * Created by PhpStorm.
 * User: Kyanush
 * Date: 27.12.2018
 * Time: 17:23
 */

namespace App\Tools;

use Mobile_Detect;
use DB;
use Auth;

class Helpers
{

    public static function searchClear($str){
        return trim(mb_strtolower($str));
    }


    public static function parseCurrentUrl(){
        $arr = [
            'https://mihome.kz',
            'https://mihome'
        ];




        $url = \Request::url();

        $url = str_replace($arr, '', $url);

        $current_url = explode('/', $url);
        $current_url = array_diff($current_url, array(0, null));
        $current_url = array_values($current_url);

        return [
            'url' => $url,
            'arr' => $current_url
        ];

    }

    public static function filtersProductsDecodeUrl($category = ''){
        $params = explode('/', url()->current());
        $filters = [];
        foreach ($params as $key => $param_item)
        {
            if($key < 6) continue;
            $code = explode('-', $param_item)[0];

            $values = str_replace($code . '-', '', $param_item);
            $values = str_replace('?', '', $values);

            $filters[$code] = (strpos($values, '-or-') !== false) ? explode('-or-', $values) : $values;
        }

        if ($category)
            $filters['category'] = $category;

        return $filters;
    }

    public static function visitNumber()
    {
        $visit_number = $_COOKIE["visit_number"] ?? false;

        if(!$visit_number)
        {
            $visit_number = sha1(md5(date('Y-m-d H:i:s') . rand(1, 100000000000)));
            setcookie("visit_number", $visit_number, time() + 5000000);
            return $visit_number;
        }

        return $visit_number;
    }

    public static function limitWords($string, $word_limit = 10)
    {
        $words = explode(" ", $string);

        if (count($words) > $word_limit) {
            return implode(" ", array_splice($words, 0, $word_limit)) . ' ...';
        }
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    public static function closeTags($content)
    {
        $position = 0;
        $open_tags = array();
        //теги для игнорирования
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //забираем все теги из контента
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //игнорируем все одиночные теги
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //тег открыт
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;
                    }
                    //тег закрыт
                    if (isset($match[1]) AND $match[1] == '/')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]--;
                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //закрываем все теги
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }

    public static function getSortedToFilter($filters){
        $value   = 'sort_view_count-asc';
        $default = true;

        foreach ($filters as $code => $filter_value)
        {
            if(is_string($filter_value))
            {
                $filter_value = mb_strtolower($filter_value);
                if($filter_value == 'asc' or $filter_value == 'desc')
                {
                    $value = $code . '-' . $filter_value;
                    $default = false;
                    break;
                }
            }
        }

        return [
            'sorting_product' => self::listSortingProducts($value),
            'default'         => $default
        ];
    }

    public static function listSortingProducts($search_value = ''){

        $sorting = [
            [
                'column' => 'view_count',
                'order'  => 'DESC',
                'title'  => 'популярные А-Я',
                'value'  => 'sort_view_count-desc'
            ],
            [
                'column' => 'view_count',
                'order'  => 'ASC',
                'title'  => 'популярные Я-А',
                'value'  => 'sort_view_count-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'ASC',
                'title'  => 'по названию А-Я',
                'value'  => 'sort_name-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'DESC',
                'title'  => 'по названию Я-А',
                'value'  => 'sort_name-desc'
            ],
            [
                'column' => 'price',
                'order'  => 'ASC',
                'title'  => 'сначала дешевые',
                'value'  => 'sort_price-asc'
            ],
            [
                'column' => 'price',
                'order'  => 'DESC',
                'title'  => 'сначала дорогие',
                'value'  => 'sort_price-desc'
            ],
            [
                'column' => 'created_at',
                'order'  => 'DESC',
                'title'  => 'новинки',
                'value'  => 'sort_created_at-desc'
            ]
        ];

        if(empty($search_value)){
            return $sorting;
        }else{
            $result = null;
            foreach ($sorting as $item)
            {
                if($item['value'] == $search_value)
                {
                    $result = $item;
                    break;
                }
            }
            return $result ? $result : self::listSortingProducts('sort_view_count-asc');
        }
    }

    public static function ruDateFormat($date)
    {
        if(empty($date))
            return 'Дата пусто';

        $day   = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year  = date('Y', strtotime($date));

        return $day . ' ' . self::monthName($month) . ' ' . $year;
    }

    public static function monthName($monthNumber){

        if(strlen($monthNumber) == 1)
            $monthNumber = '0' . $monthNumber;

        $months = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря'
        ];
        return $months[ $monthNumber ] ?? '';
    }

    public static function createTree(&$list, $parentId = null)
    {
        $tree = array();
        foreach ($list as $key => $eachNode) {
            if ($eachNode['parent_id'] == $parentId) {
                $eachNode['children'] = self::createTree($list, $eachNode['id']);
                $tree[] = $eachNode;
                unset($list[$key]);
            }
        }
        return $tree;
    }

    public static function priceFormat($price, $show_currency = true){
        return number_format($price, 0, ',', ' ') . ($show_currency ? ' ₸' : '');
    }


    public static function sortConvert($value, $column = 'id', $order = 'DESC'){
        if($value)
        {
            $sort = explode('-', $value);
            if(isset($sort[0]) and isset($sort[1]))
            {
                $column = $sort[0];
                $order  = $sort[1];
            }
        }

        return [
            'column' => $column,
            'order'  => $order
        ];
    }


    public static function isAdmin(){
        if(Auth::check())
            if(Auth::user()->hasRole('admin'))
                return true;
        return false;
    }

    public static function whatsAppNumber($phone){
        if(!$phone)
            return '';

        $phone = preg_replace("/[^0-9]/", '', $phone);

        if ($phone[0] == '8' or $phone[0] == '+') {
            $phone = substr($phone, 1);
        }

        if(strlen($phone) == 10)
            $phone = '7' . $phone;

        return $phone;
    }

    public static function getBrands(){
        $brands = [
            [
                'name' => 'apple',
                'url'  => route('apple'),
                'img'  => '/site/images/brands/apple.png',
                'type' => 'image'
            ],
            [
                'name' => 'samsung',
                'url'  => '/samsung',
                'img'  => '/site/images/brands/samsung.png',
                'type' => 'image'
            ],
            [
                'name' => 'xiaomi',
                //'url'  => '/xiaomi',
                'img'  => '/site/images/brands/xiaomi.png',
                'type' => 'image'
            ],
            [
                'name' => 'meizu',
                'url'  => '/telefon/meizu',
                'img'  => '/site/images/brands/meizu.png',
                'type' => 'image'
            ],
            [
                'name' => 'huawei',
                //'url'  => '/huawei',
                'img'  => '/site/images/brands/huawei.png',
                'type' => 'image'
            ],
            [
                'name' => 'honor',
                //'url'  => '/honor',
                'img'  => '/site/images/brands/honor.png',
                'type' => 'image'
            ],

            [
                'name' => 'oneplus',
                'url'  => '/telefon/oneplus',
                'img'  => '/site/images/brands/oneplus.png',
                'type' => 'image'
            ],
            [
                'name' => 'oppo',
                'url'  => '/telefon/oppo',
                'img'  => '/site/images/brands/oppo.png',
                'type' => 'image'
            ],

                /*

                 [
                'name' => 'asus',
                //'url'  => '/asus',
                'img'  => '/site/images/brands/asus.png',
                'type' => 'image'
            ],
            [
                'name' => 'lenovo',
                //'url'  => '/lenovo',
                'img'  => '/site/images/brands/lenovo.png',
                'type' => 'image'
            ],
            [
                'name' => 'zte',
                'url'  => '/telefon/zte',
                'img'  => '/site/images/brands/zte.png',
                'type' => 'image'
            ],
            [
                'name' => 'nokia',
                'url'  => '/telefon/nokia',
                'img'  => '/site/images/brands/nokia.png',
                'type' => 'image'
            ],
            [
                'name' => 'leeco',
                'url'  => '/telefon/leeco',
                'img'  => '/site/images/brands/leeco.png',
                'type' => 'image'
            ],
            [
                'name' => 'bq',
                'url'  => '/telefon/bq',
                'img'  => '/site/images/brands/bq.png',
                'type' => 'image'
            ],
            [
                'name' => 'htc',
                'url'  => '/telefon/htc',
                'img'  => '/site/images/brands/htc.png',
                'type' => 'image'
            ],
            [
                'name' => 'sony',
                'url'  => '/sony',
                'img'  => '<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 536 124" xmlns:xlink="https://www.w3.org/1999/xlink" width="250px" height="80px" style="padding-left: 7px; padding-top: 10px;"><g fill="#82a8cf"><path d="M179.106,88.578 C160.994,88.578 144.183,83.144 132.96,73.074 C124.479,65.464 120.405,55.124 120.405,44.486 C120.405,33.973 124.655,23.565 132.96,15.996 C143.377,6.498 161.782,0.549 179.106,0.549 C198.278,0.549 213.624,5.378 225.355,16.021 C233.702,23.597 237.739,33.959 237.739,44.486 C237.739,54.691 233.454,65.558 225.355,73.074 C214.433,83.21 197.268,88.578 179.106,88.578 L179.106,76.966 C188.722,76.966 197.638,73.646 203.864,67.453 C210.051,61.298 212.933,53.73 212.933,44.486 C212.933,35.625 209.823,27.346 203.864,21.473 C197.719,15.418 188.591,12.013 179.106,12.013 C169.595,12.013 160.456,15.385 154.309,21.473 C148.383,27.342 145.267,35.65 145.267,44.486 C145.267,53.292 148.415,61.589 154.309,67.453 C160.46,73.574 169.566,76.966 179.106,76.966 L179.106,88.578"></path><path d="M46.724,0.591 C37.036,0.591 26.026,2.404 16.677,6.58 C8.046,10.433 0.979,16.66 0.979,26.986 C0.974,36.285 6.885,41.73 6.724,41.582 C9.239,43.896 13.286,47.837 23.866,50.154 C28.596,51.187 38.706,52.773 48.776,53.829 C58.767,54.882 68.605,55.882 72.608,56.898 C75.791,57.708 81.142,58.812 81.142,64.808 C81.142,70.783 75.509,72.607 74.529,72.999 C73.55,73.39 66.792,76.488 54.647,76.488 C45.679,76.488 34.899,73.79 30.968,72.386 C26.44,70.773 21.687,68.64 17.255,63.228 C16.152,61.882 14.414,58.193 14.414,54.537 L3.419,54.537 L3.419,85.341 L15.64,85.341 C15.64,85.341 15.64,81.962 15.64,81.177 C15.64,80.704 16.23,78.753 18.282,79.683 C20.835,80.843 28.326,83.826 36.159,85.462 C42.582,86.802 46.724,87.765 54.708,87.765 C67.735,87.765 74.735,85.646 79.573,84.263 C84.132,82.96 89.762,80.615 94.34,76.966 C96.815,74.994 102.249,69.935 102.249,60.755 C102.249,51.947 97.522,46.478 95.858,44.814 C93.593,42.548 90.823,40.787 87.938,39.433 C85.427,38.252 81.46,36.832 78.216,36.037 C71.917,34.49 57.677,32.584 50.864,31.872 C43.725,31.125 31.335,30.098 26.388,28.566 C24.887,28.101 21.833,26.644 21.833,23.097 C21.833,20.571 23.229,18.43 25.993,16.699 C30.38,13.952 39.241,12.24 48.481,12.24 C59.401,12.202 68.651,14.7 74.535,17.328 C76.538,18.221 78.876,19.507 80.737,21.025 C82.833,22.736 85.784,26.289 86.846,31.248 L96.716,31.248 L96.716,4.435 L85.696,4.435 L85.696,7.549 C85.696,8.558 84.658,9.865 82.695,8.782 C77.762,6.198 63.816,0.615 46.724,0.591"></path><path d="M288.223,5.464 L341.98,53.976 L341.43,21.314 C341.373,17.03 340.584,15.242 335.953,15.242 C329.762,15.242 325.844,15.242 325.844,15.242 L325.844,5.472 L371.811,5.472 L371.811,15.242 C371.811,15.242 368.141,15.242 361.947,15.242 C357.225,15.242 356.928,16.755 356.867,21.314 L357.701,83.728 L341.959,83.728 L280.047,28.467 L280.057,67.683 C280.113,71.949 280.311,73.954 284.703,73.954 C290.889,73.954 295.744,73.954 295.744,73.954 L295.744,83.724 L250.602,83.724 L250.602,73.954 C250.602,73.954 254.967,73.954 261.154,73.954 C265.096,73.954 264.939,70.197 264.939,67.462 L264.939,21.684 C264.939,18.73 264.523,15.248 258.336,15.248 L249.775,15.248 L249.775,5.464 L288.223,5.464"></path><path d="M424.332,73.937 C424.762,73.937 426.68,73.88 427.051,73.767 C428.113,73.437 428.834,72.679 429.168,71.89 C429.309,71.56 429.379,70.091 429.379,69.777 C429.379,69.777 429.385,54.849 429.385,54.333 C429.385,53.962 429.357,53.8 428.729,52.976 C428.035,52.07 400.572,20.947 399.314,19.578 C397.754,17.874 395.014,15.244 390.846,15.244 C387.533,15.244 381.297,15.244 381.297,15.244 L381.297,5.468 L435.197,5.468 L435.197,15.23 C435.197,15.23 429.953,15.23 428.699,15.23 C427.199,15.23 426.201,16.656 427.482,18.24 C427.482,18.24 445.619,39.934 445.791,40.164 C445.961,40.392 446.105,40.449 446.334,40.235 C446.561,40.02 464.924,18.441 465.068,18.269 C465.941,17.224 465.354,15.244 463.469,15.244 C462.211,15.244 456.799,15.244 456.799,15.244 L456.799,5.468 L500.979,5.468 L500.979,15.244 C500.979,15.244 494.422,15.244 491.109,15.244 C487.527,15.244 486.07,15.904 483.377,18.951 C482.145,20.344 454.389,52.027 453.633,52.886 C453.236,53.335 453.273,53.962 453.273,54.333 C453.273,54.929 453.273,68.341 453.273,69.771 C453.273,70.083 453.344,71.552 453.484,71.882 C453.816,72.675 454.539,73.431 455.602,73.759 C455.973,73.874 457.865,73.931 458.295,73.931 C460.234,73.931 468.391,73.931 468.391,73.931 L468.391,83.704 L414.766,83.704 L414.766,73.931 L424.332,73.937"></path></g></svg>',
                'type' => 'svg'
            ],


        [
            'name' => 'motorola',
            'url'  => '/telefon/motorola',
            'img'  => '/site/images/brands/motorola.png',
            'type' => 'image'
        ],
        [
            'name' => 'google',
            'url'  => '/telefon/google',
            'img'  => '/site/images/brands/google.png',
            'type' => 'image'
        ],
        [
            'name' => 'fly',
            'url'  => '/telefon/fly',
            'img'  => '/site/images/brands/fly.png',
            'type' => 'image'
        ],
        [
            'name' => 'micromax',
            'url'  => '/telefon/micromax',
            'img'  => '/site/images/brands/micromax.png',
            'type' => 'image'
        ],

        [
            'name' => 'beats',
            'url'  => '',//naushnikov/beats
            'img'  => '/site/images/brands/beats.png',
            'type' => 'image'
        ],
        [
            'name' => 'sennheiser',
            'url'  => '',//naushnikov/sennheiser
            'img'  => '/site/images/brands/sennheiser.png',
            'type' => 'image'
        ],
        [
            'name' => 'acer',
           // 'url'  => '/acer',
            'img'  => '/site/images/brands/acer.png',
            'type' => 'image'
        ],
        [
            'name' => 'dell',
           // 'url'  => '/dell',
            'img'  => '/site/images/brands/dell.png',
            'type' => 'image'
        ],
        [
            'name' => 'msi',
            //'url'  => '/msi',
            'img'  => '/site/images/brands/msi.png',
            'type' => 'image'
        ],
        [
            'name' => 'hp',
            //'url'  => '/hp',
            'img'  => '/site/images/brands/hp.png',
            'type' => 'image'
        ],
        [
            'name' => 'alienware',
            //'url'  => '/alienware',
            'img'  => '/site/images/brands/alienware.png',
            'type' => 'image'
        ],
        [
            'name' => 'dji',
            'url'  => '',//kvadrokopterov/dji
            'img'  => '/site/images/brands/dji.png',
            'type' => 'image'
        ],
        [
            'name' => 'PLAYSTATION',
            'url'  => '',//pristavok/playstation
            'img'  => '/site/images/brands/PLAYSTATION.png',
            'type' => 'image'
        ],
        [
            'name' => 'XBOX',
            'url'  => '',//pristavok/xbox
            'img'  => '/site/images/brands/XBOX.png',
            'type' => 'image'
        ],*/
        ];

        return $brands;
    }


    public static function barcode(){
        $number = \DB::selectOne('select * from t_barcode where id = 1')->number;
        $number++;

        \DB::update("update t_barcode set number = $number where id = 1");

        $n = 13 - strlen((string)$number);
        for($i = 1; $i <= $n; $i++)
        {
            $number = '0' . $number;
        }

        return $number;
    }

    public static function isMobile(){
        //return false;
        //mobile
        $detect = new Mobile_Detect();
        if($detect->isMobile())
            return true;
        else
            return false;
    }

}