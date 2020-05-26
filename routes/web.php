<?php

//https://api.telegram.org/bot1178569369:AAGYPEtvgvfSihzKY7fp5LfY0xADo_GV8r4/setWebHook?url=https://mihome.kz/telegram

Route::group(['namespace'  => 'Telegram'], function () {
    Route::post('/telegram', 'MainController@telegram');
});


Route::get('/dddd', function (){


    $dd = new \App\Services\ServiceTelegram();
    $dd->sendOrder(343);

  //  $DDD =  new \App\Console\Commands\xiaomi_store_kz();
   // $DDD->handle();

    /*
    $dd = \App\Models\Product::where('parent_id', 0)->where('id', '>', 2942)->get();
    foreach ($dd as $dddd)
    {
        \App\Services\ServiceProduct::productDelete($dddd->id);

    }*/

/*

    require '/home/c/cv80930/mihome.kz/public_html/parsing/simple_html_dom.php';


    function parse($product_url, $parent_id = 0){
        $base = 'https://xiaomi-store.kz';
        $product_html = @file_get_html($base . $product_url);
        if($product_html)
        {

            $product_description = $product_html->find('.product-description', 0);
            foreach ($product_description->find('img') as $img)
            {


                $serviceUploadUrl = new \App\Services\ServiceUploadUrl();
                //$serviceUploadUrl->name = str_slug($category->name);
                $serviceUploadUrl->url = $base . $img->{'data-src'};
                $serviceUploadUrl->path_save = public_path('images/redmi-8a/');
                $serviceUploadUrl->copy();

            }

        }
    }

    parse('/store/smartphone/redmi-8a');
    */

    require '/home/c/cv80930/mihome.kz/public_html/parsing/simple_html_dom.php';



    function parse($product_url, $parent_id = 0){
        $base = 'https://xiaomi-store.kz';


        $product_html = @file_get_html($base . $product_url);


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

                dd($price);

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
                        $parent_id = 0;
                        foreach($thumbnails->find('a') as $key => $a)
                        {
                            if ($key > 0)
                            {
                                $href = $a->href;
                                if($href)
                                {
                                    $catalog = file_get_html($base . $href);

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

                                $name  = trim($value[1] ?? false);
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
                            parse($url2, $product->id);
                        }
                    }
                }
            }




        }
    }



    parse('/store/smartphone/mi-note-10');


});


Route::group(['namespace'  => 'Site'], function () {
    //главная страница
    Route::get('/',          'MainController@main')->name('index');

    //поиск товара
    Route::get('product-search', 'ProductController@productSearch');

    //Корзина
    Route::post('cart-save',                'CartController@cartSave');
    Route::post('cart-delete/{product_id}', 'CartController@cartDelete')->where(['product_id' => '[0-9]+']);
    Route::get('cart-total/{carrier_id?}',  'CartController@cartTotal')->where(['carrier_id' => '[0-9]+']);;
    Route::get('header-cart-info',          'CartController@header_cart_info');

    //Оформление заказа
    Route::get('checkout',   'CartController@checkout')->name('checkout');
    Route::post('checkout',  'CartController@saveCheckout');
    Route::post('one-click-order',  'CartController@oneClickOrder');

    //Оформление заказа ajax
    Route::post('list-cart',                'CartController@listCart');
    Route::post('list-carriers',            'CarrierController@listCarriers');
    Route::post('list-payments',            'PaymentController@listPayments');

    //попап в корзину
    Route::post('get-product/{product_id}', 'ProductController@getProduct')->where(['product_id' => '[0-9]+']);

    //количество - Сравнение товаров
    Route::get('product-features-compare-count',         'ProductFeaturesCompareController@count');
    //Добавление - Сравнение товаров
    Route::post('product-features-compare/{product_id}', 'ProductFeaturesCompareController@addAndDelete')->where(['product_id' => '[0-9]+']);
    //Сравнение товаров
    Route::get('compare-products',                       'ProductFeaturesCompareController@compareProducts')->name('compare_products');
    Route::get('compare-product-delete/{product_id}',    'ProductFeaturesCompareController@compareProductDelete')->where(['product_id' => '[0-9]+'])->name('compare_product_delete');

    //Мои закладки
    Route::get('wishlist',                         'ProductFeaturesWishlistController@wishlist')->name('wishlist');
    //количество - Мои закладки
    Route::get('product-features-wishlist-count',  'ProductFeaturesWishlistController@count');

    //Обратный звонок
    Route::post('callback',  'CallbackController@callback');
    //Написать руководителю
    Route::post('contact',  'CallbackController@contact');
    //подписка
    Route::post('subscribe', 'SubscribeController@subscribe');


    $params = '';
    for ($i = 0; $i <= 50; $i++)
        $params .= "/{param$i?}";

    //каталог иобильный
    Route::get('c/{category}', 'CatalogController@c')->where(['category'])->name('category_menu_mobile');

    //каталог
    Route::get('catalog/{code}' . $params,  'CatalogController@catalog')->where(['code'])->name('catalog');


    //товар детально
    Route::get('p/{product_url}',         'ProductController@productDetail')
        ->where(['product_url'])
        ->name('productDetail');




    //мобильный получить картинки
    Route::post('product-images/{product_id}',   'ProductController@productImages')->where(['product_id' => '[0-9]+']);


    Route::post('set-rating',   'ProductController@setRating');



    //лайк Отзывы
    Route::post('product-review-set-like', 'ReviewController@setLike');
    //отправка - Отзывы
    Route::post('write-review',            'ReviewController@writeReview');
    //отправка - Вопрос-ответ
    Route::post('write-question',          'QuestionAnswerController@writeQuestion');
    //страницы
    Route::get('delivery-payment',         'PageController@deliveryPayment')->name('delivery_payment');
    Route::get('guaranty',                 'PageController@guaranty')->name('guaranty');
    Route::get('contact',                  'PageController@contact')->name('contact');
    Route::get('about',                    'PageController@about')->name('about');
    Route::get('cashback',                 'PageController@cashback')->name('cashback');

    //выбор города
    Route::post('set-city/{city_code}',    'CityController@setCity');

    Route::get('electric-scooter-service',  'PageController@electricScooterService')->name('electricScooterService');

    //новости
    Route::get('news',                    'NewsController@newsList')->name('news_list');
    Route::get('news/{code}',             'NewsController@newsDetail')->name('news_detail');

});

Route::group(['middleware' => 'auth', 'namespace'  => 'Site'], function () {

    Route::post('product-features-wishlist/{product_id}', 'ProductFeaturesWishlistController@addAndDelete')->where(['product_id' => '[0-9]+']);

    Route::get('my-account',    'UserController@myAccount')->name('my_account');
    Route::get('account-edit',  'UserController@accountEdit')->name('account_edit');
    Route::post('account-edit', 'UserController@accountEditSave');

    Route::get('change-password',  'UserController@changePassword')->name('change_password');
    Route::post('change-password', 'UserController@changePasswordSave');

    Route::get('order-history',             'OrderController@orderHistory')->name('order_history');
    Route::get('order-history/{order_id}',  'OrderController@orderHistoryDetail')->where(['order_id' => '[0-9]+'])->name('order_history_detail');

    Route::get('wishlist-delete/{product_id}',  'ProductFeaturesWishlistController@delete')->where(['product_id' => '[0-9]+'])->name('wishlist_delete');

});

Route::get('/parsing', function(){

});

Auth::routes();
