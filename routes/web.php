<?php

//https://api.telegram.org/bot1178569369:AAGYPEtvgvfSihzKY7fp5LfY0xADo_GV8r4/setWebHook?url=https://mihome.kz/telegram

Route::group(['namespace'  => 'Telegram'], function () {
    Route::post('/telegram', 'MainController@telegram');
});


Route::get('/dddd111', function (){



    /*
    $cc = \App\Models\Category::all();
    foreach ($cc as $item)
    {
        $url_full = '/catalog/';
        $ddd = \App\Services\ServiceCategory::getParents($item->id);
        $ddd = array_reverse($ddd);

        foreach ($ddd as $item2)
        {
            $url_full.= $item2->url . '/';
        }

        $url_full = mb_substr($url_full, 0, -1);

        $item->url_full = $url_full;
        $item->save();
    }
    */

    /*
    $pod = \App\Models\Product::all();
    foreach ($pod as $product)
    {

        $url_full = '';
        if(!$product->parent_id)
        {
            $category = $product->categories()->first();
            if($category)
                $url_full = $category->url_full . '/' . $product->url;

        }else{
            if($product->parent){
                $category = $product->parent->categories()->first();
                if($category)
                    $url_full = $category->url_full . '/' . $product->url;
            }
        }

        if($url_full)
        {
            $product->url_full = $url_full;
            $product->save();
        }

    }*/

});


Route::get('/dddd', function (){


    $dd = \App\Models\Product::with('categories')->where('parent_id', 0)->get();
    foreach ($dd as $dddd)
    {
        $category_id = $dddd->categories[0]->id ?? '';
        if($category_id)
        {
            $dddd->category_id = $dddd->categories[0]->id;
            $dddd->save();
        }
    }

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
    for ($i = 0; $i <= 5; $i++)
        $params .= "/{param$i?}";

    //каталог

    Route::get('/catalog',  'CatalogController@catalog');
    Route::get('catalog/{code}' . $params,  'CatalogController@catalog')->where(['code'])->name('catalog');


    //товар детально
    Route::get('p/{url}', function($url){
        $product = \App\Models\Product::where('url', $url)->firstOrFail();
        return Redirect::to($product->url_full, 301);
    });



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
