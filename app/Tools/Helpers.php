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

class Helpers
{

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
        $value   = 'sort_viewed-asc';
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
                'column' => 'viewed',
                'order'  => 'DESC',
                'title'  => 'популярные',
                'value'  => 'sort_viewed-desc'
            ],
            [
                'column' => 'viewed',
                'order'  => 'ASC',
                'title'  => 'популярные',
                'value'  => 'sort_viewed-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'ASC',
                'title'  => 'по названию',
                'value'  => 'sort_name-asc'
            ],
            [
                'column' => 'name',
                'order'  => 'DESC',
                'title'  => 'по названию',
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
            return $result ? $result : self::listSortingProducts('sort_viewed-asc');
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

    public static function isMobile(){
        //return false;


        //mobile
        $detect = new Mobile_Detect();
        if($detect->isMobile())
            return true;
        else
            return false;
    }

    public static function tableNextId($tableName){
        $statement = DB::select("show table status like '" . env('DB_TABLE_PREFIX') . $tableName . "'");
        return $statement[0]->Auto_increment;
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

}