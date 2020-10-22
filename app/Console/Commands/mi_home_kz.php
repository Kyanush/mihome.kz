<?php

namespace App\Console\Commands;

use App\Tools\Helpers;
use Illuminate\Console\Command;
use Mail;

class mi_home_kz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mi_hone_kz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */


    public function fileGetHtml($url)
    {
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $product_html = @file_get_html($url, false, stream_context_create($arrContextOptions));
        return $product_html;
    }

    public function parse($product_url, $parent_id = 0){
        $base = 'https://mi-home.kz';
        $product_html = $this->fileGetHtml($base . $product_url);
        if($product_html)
        {

            $sku 			     = trim($product_html->find('span[itemprop=sku]', 0)->plaintext);
            $name 			     = trim($product_html->find('h1#product-name', 0)->plaintext);
            $comment_id         = $product_html->find('div[type=lis-comments]', 0)->{'data-id'} ?? 0;

            if($name == 'Подарочный сертификат' or $name == 'realme 6i' or $name == 'Realme C3' or $name == 'Realme 6i'){
                return false;
            }

            $product = \App\Models\Product::where(function($query) use ($name, $sku){
                $query->Where('name', $name);
                //$query->OrWhere('sku',  $sku);
            })->first();


            $new = false;
            if(!$product){
                $new = true;
                $product = new \App\Models\Product();
            }else{
                if(!$product->update_price)
                    return false;
            }



            $status = $product_html->find('div.product-price', 0);
            if($status)
                $status 		     = trim($status->children(0)->plaintext ?? false);




            if($product_html->find('div.PricesalesPrice', 0))
            {
                $price 			     = trim($product_html->find('div.PricesalesPrice', 0)->plaintext);

                if(strpos($price, '-') !== false)
                {
                    $price = explode('-', $price)[0];
                }

                $price = preg_replace("/[^0-9]/", '', $price);
                $price = (int)trim($price);

                if($price > 150000){
                    $price = $price - 1000;

                }else{
                    $price = $price + 2000;
                }

                /*
                if($price < 10000){
                    $price += 3000;

                }elseif ($price < 20000){
                    $price += 4000;

                }elseif ($price < 40000){
                    $price += 7000;

                }elseif ($price < 50000){
                    $price += 9000;

                }elseif ($price < 100000){
                    $price += 12000;

                }elseif ($price < 200000){
                    $price += 22000;

                }elseif ($price < 300000){
                    $price += 25000;
                }
                */

            }else{
                $price = 0;
            }

            //10 - В наличии
            //11 - Скоро в продаже
            //12 - Нет в наличии

            if($status == 'Товар в наличии'){
                $status_id = 10;
            }elseif ($status == 'Ожидаем поступление'){
                $status_id = 11;
            }else{
                $status_id = 12;
            }

            $product->price      = $price;
            $product->status_id  = $status_id;
            $product->comment_id = $comment_id;



            if($parent_id)
                $product->parent_id = $parent_id;

            if(!$new){
                $product->save();


                //Helpers::sendTestEmail('mi_home_kz.php');

/*
                if(!$parent_id)
                {
                    $attr = $product->attributes()->wherePivot(\DB::raw('name'), \DB::raw('value'))->first();
                    if($attr)
                    {

                        $attributes = [];
                        $a1 = $product_html->find('ul#tab-content', 0);
                        if($a1)
                        {
                            $a1 = $a1->children(1);
                            foreach ($a1->find('li') as $element)
                            {
                                $value = explode(':', $element->plaintext);

                                $name  = trim($value[0] ?? false);
                                $value = trim($value[1] ?? false);

                                if($name and $value)
                                    $attributes[] = [
                                        'attribute_id' => 1,
                                        'name'  => $name,
                                        'value' => $value
                                    ];
                            }
                        }
                        if (count($attributes) > 0)
                            \App\Services\ServiceProduct::productAttributesSave($product->id, $attributes);
                    }
                }else{
                    $product->attributes()->detach();
                }*/




            }else{

                $images = [];
                $thumbnails = $product_html->find('ul#thumbnails', 0);
                if($thumbnails)
                {
                    if($thumbnails->find('img'))
                    {
                        foreach ($thumbnails->find('img') as $element)
                        {
                            $src = $element->{'data-src'};
                            if (strpos($src, '.jpg') !== false or
                                strpos($src, '.png') !== false or
                                strpos($src, '.jpeg') !== false) {
                                $images[] = [
                                    'id' => 0,
                                    'value' => $base . $element->{'data-src'},
                                    'is_delete' => 0
                                ];
                            }
                        }
                    }
                }else{

                    $big_product_image = $product_html->find('img#big-product-image', 0);
                    if($big_product_image)
                        $images[] = [
                            'id'        => 0,
                            'value'     => $base .  $big_product_image->{'data-src'},
                            'is_delete' => 0
                        ];
                    else{
                        dd($name);
                    }
                }


                $product->name = $name;
                $product->sku = $sku;

                if(!$parent_id)
                {
                    $description_short           = trim($product_html->find('div[itemprop=description]', 0)->plaintext ?? '');
                    $product->description_short  = $description_short;

                    $json = $product_html->find("script[type='application/ld+json']", 1)->innertext;
                    if($json)
                    {
                        $json = json_decode($json);

                        $product->description_schema = $json->description ?? '';
                        $product->reviews_rating_avg = (int)($json->aggregateRating->ratingValue ?? 0);
                        $product->reviews_count      = (int)($json->aggregateRating->reviewCount ?? 0);
                    }
                }

                if($images[0]['value'] ?? false)
                    $product->photo = $images[0]['value'];

                /*
                $description = $product_html->find('div.product-description', 0)->innertext ?? '';
                if($description)
                {
                    $description = str_replace('jch-lazyload', "lazy", $description);
                    $description = str_replace('data-src', "data-original", $description);
                    $product->description = $description;
                }
                */

                if ($product->save())
                {
                    if(!$parent_id)
                    {
                        $thumbnails = $product_html->find('ul.uk-breadcrumb', 0);
                        $parent_id = 10;
                        foreach($thumbnails->find('a') as $key => $a)
                        {
                            if ($key > 0)
                            {
                                $href = $a->href;
                                if($href)
                                {
                                    $catalog = $this->fileGetHtml($base . $href);

                                    $title = $catalog->find('title', 0)->plaintext;
                                    $title = explode('-', $title)[0];
                                    $h1    = $catalog->find('h1', 0)->plaintext;
                                    $image = $catalog->find('meta[property="og:image"]', 0)->content;

                                    $category = \App\Models\Category::where(['name' => $h1])->first();
                                    if(!$category)
                                    {
                                        $category = new \App\Models\Category();
                                        $category->seo_title = $title;
                                        $category->name      = $h1;
                                        $category->image     = $image;
                                        $category->parent_id = $parent_id;
                                        $category->save();
                                    }

                                    $parent_id = $category->id;
                                }
                            }
                        }

                        /*
                        $category_name = trim($thumbnails->find('li', count($thumbnails->find('li')) - 2)->plaintext);
                        $category = \App\Models\Category::where('name', $category_name)->first();
                        if(!$category)
                        {
                            $category = new \App\Models\Category();
                            $category->name = $category_name;
                            $category->parent_id = 10;
                            $category->save();
                        }
                        */

                        if(isset($category->id) ?? false)
                            $product->categories()->sync([$category->id]);

                        unset($images[0]);

                        if (count($images))
                            \App\Services\ServiceProduct::productImagesSave($images, $product->id);


                        $attributes = [];
                        $a1 = $product_html->find('ul#tab-content', 0);
                        if($a1)
                        {
                            //if(count($a1->find('li')) == 3)
                            //{
                            $a1 = $a1->children(1);
                            foreach ($a1->find('li') as $element)
                            {
                                $value = explode(':', $element->plaintext);

                                $name  = trim($value[0] ?? false);
                                $value = trim($value[1] ?? false);

                                if($name and $value)
                                    $attributes[] = [
                                        'attribute_id' => 1,
                                        'name'  => $name,
                                        'value' => $value
                                    ];
                            }
                            //}
                        }


                        if (count($attributes) > 0)
                            \App\Services\ServiceProduct::productAttributesSave($product->id, $attributes);




                        /*
                        $description_object = $product_html->find('div.product-description', 0);
                        if ($description_object)
                        {
                            if($description_object->find('img'))
                            {
                                foreach ($description_object->find('img') as $element)
                                {
                                    $src = $element->{'data-src'};
                                    if (strpos($src, '.jpg') !== false or
                                        strpos($src, '.png') !== false or
                                        strpos($src, '.jpeg') !== false) {
                                        $path = explode('/', $src)[2];
                                        $path = public_path('images/' . $path);

                                        $name = explode('/', $src)[3];
                                        $name = pathinfo($name);
                                        $name = $name['filename'];

                                        File::makeDirectory($path, 0777, true, true);
                                        $serviceUploadUrl = new \App\Services\ServiceUploadUrl();
                                        $serviceUploadUrl->name = $name;
                                        $serviceUploadUrl->url = $base . $src;
                                        $serviceUploadUrl->path_save = $path . '/';
                                        $serviceUploadUrl->copy();

                                    }
                                }
                            }
                        }*/
                    }

                }
            }



            if(!$parent_id)
            {
                $avselection = $product_html->find('select.avselection', 0);
                if ($avselection) {
                    foreach ($avselection->find('option') as $k => $option) {
                        if ($k > 0) {
                            $url2 = $option->value;
                            $this->parse($url2, $product->id);
                        }
                    }
                }
            }




        }
    }

    public function handle()
    {

        /*
        $mgs = '/home/c/cv80930/mihome.kz/public_html/parsing/simple_html_dom.php';
        Mail::raw($mgs, function($message){
            $message->to('zheksenkulov.kuanysh@gmail.com');
        });*/

        require '/home/c/cv80930/mihome.kz/public_html/parsing/simple_html_dom.php';





        $site = 'mi-home.kz';

        $count        =  \App\Models\CronParsing::where('site', $site)->count();
        $cron_parsing = \App\Models\CronParsing::where('parsing', 1)->where('site', $site)->count();


        if($cron_parsing == $count)
        {
            \App\Models\CronParsing::where('site', $site)->update([
                'parsing' => 0
            ]);
        }
        $cron_parsing = \App\Models\CronParsing::where('parsing', 0)->where('site', $site)->first();

        if($cron_parsing)
        {
            $cron_parsing->parsing = 1;
            $cron_parsing->save();

            $page = $this->fileGetHtml($cron_parsing->url);


            dd(
                file_get_contents($cron_parsing->url)
            );

            if($page)
            {
                $center_products = $page->find('div#center-products', 0);

                foreach ($center_products->find('h3') as $element)
                {
                    $product_url = $element->find('a', 0)->href;
                    $this->parse($product_url);
                }
            }
        }


    }
}
