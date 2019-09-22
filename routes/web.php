<?php

//загрузить файл
Route::post('ckeditor-upload-image',   'UploadImageController@CkeditorUploadImage');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
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
    Route::get('c/{cCategory}',                          'CatalogController@c')->where(['cCategory']);

    //каталог
    Route::get('{city}/catalog/{category}'   . $params,  'CatalogController@catalogCity')
        ->where(['city'])
        ->where(['category'])
        ->name('catalogCity');

    Route::get('catalog/{category}'          . $params,  'CatalogController@catalog')
        ->where(['category'])
        ->name('catalog');

    //товар детально
    Route::get('p/{product_url}',         'ProductController@productDetailDefault')
        ->where(['product_url'])
        ->name('productDetailDefault');
    Route::get('{city}/p/{product_url}',  'ProductController@productDetailCity')
        ->where(['city'])
        ->where(['product_url'])
        ->name('productDetailCity');

    //мобильный получить картинки
    Route::post('product-images/{product_id}',   'ProductController@productImages')->where(['product_id' => '[0-9]+']);

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
    //выбор города
    Route::post('set-city/{city_code}',    'CityController@setCity');

    //новости
    Route::get('news',                    'NewsController@newsList')->name('news_list');
    Route::get('news/{code}',             'NewsController@newsDetail')->name('news_detail');

});


//sitemap
Route::group(['namespace'  => 'Sitemap', 'as' => 'sitemap.'], function () {

    Route::get('sitemap.xml', 'SitemapController@sitemap');
    Route::get('pages.xml',   'SitemapController@pages')->name('pages');
    Route::get('news.xml',    'SitemapController@news')->name('news');

    $cities     = \App\Services\ServiceCity::listActiveSort();
    foreach ($cities as $city)
        Route::get($city->code . '.xml',   'SitemapController@city')->name($city->code);

});


//YANDEX
Route::group(['namespace'  => 'Yandex', 'as' => 'yandex.'], function () {
    Route::get('market-export.xml', 'MarketExportController@marketExport');
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












// Admin Interface
Route::group(['middleware' => ['role:admin'], 'prefix'     => 'admin', 'namespace'  => 'Admin'], function () {

    Route::get('report-goods/{format}',          'ReportController@goods');
    Route::get('yandex-directory/{format}',      'ReportController@yandexDirectory');

    if (!request()->ajax()){
        Route::get('/{any}', 'AdminController@index')->where('any', '.*');

        Route::get('/', function () {
            return redirect('/admin/main');
        });

    }else{

        Route::get('categories-list',          'CategoryController@list');
        Route::get('category-view/{id}',       'CategoryController@view')->where(['id' => '[0-9]+']);
        Route::get('catalogs-tree/{type}',     'CategoryController@catalogsTree')->where(['type' => '[0-9]+']);


        Route::post('category-save',          'CategoryController@save');
        Route::post('category-delete/{id}',    'CategoryController@delete')->where(['id' => '[0-9]+']);
        Route::post('reorder-save',            'CategoryController@reorderSave');

        Route::get('attributes-list',          'AttributeController@list');
        Route::post('attribute-save',          'AttributeController@save');
        Route::get('attribute-view/{id}',      'AttributeController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-delete/{id}',   'AttributeController@delete')->where(['id' => '[0-9]+']);

        Route::get('attributes-sets-list ',      'AttributeSetController@list');
        Route::post('attribute-set-save',        'AttributeSetController@save');
        Route::get('attribute-set-view/{id}',    'AttributeSetController@view')->where(['id' => '[0-9]+']);
        Route::post('attribute-set-delete/{id}', 'AttributeSetController@delete')->where(['id' => '[0-9]+']);

        Route::any('products-list',                  'ProductController@list');
        Route::get('attribute-sets-more-info',       'ProductController@AttributeSetsMoreInfo');
        Route::post('product-save',                  'ProductController@save');
        Route::get('product-view/{id}',              'ProductController@view')->where(['id' => '[0-9]+']);
        Route::post('product-delete/{id}',           'ProductController@delete')->where(['id' => '[0-9]+']);
        Route::post('product-price-min-max',         'ProductController@priceMinMax');
        Route::post('products-attributes-filters',   'ProductController@productsAttributesFilters');
        Route::get('group-products/{group_id}',      'ProductController@groupProducts')->where(['group_id' => '[0-9]+']);
        Route::post('clone-product',                 'ProductController@cloneProduct');
        Route::any('search-products',                'ProductController@searchProducts');

        //отзывы
        Route::get('reviews-list',                'ReviewController@list');
        Route::post('review-delete/{review_id}',  'ReviewController@delete')->where(['review_id' => '[0-9]+']);
        Route::post('review-save',                'ReviewController@save');

        //Вопросы-ответы
        Route::get('questions-answers-list',               'QuestionAnswerController@list');
        Route::post('question-answer-delete/{review_id}',  'QuestionAnswerController@delete')->where(['review_id' => '[0-9]+']);
        Route::post('question-answer-save',                'QuestionAnswerController@save');

        //Пользователи
        Route::get('users-list',        'UserController@list');
        Route::get('user-view/{id}',    'UserController@view')->where(['id' => '[0-9]+']);
        Route::post('user-save',        'UserController@save');
        Route::post('user-delete/{id}', 'UserController@delete')->where(['id' => '[0-9]+']);

        //Роли
        Route::get('roles-list',        'RoleController@list');

        //Курьеры
        Route::get('carriers-list',              'CarrierController@list');
        Route::post('carrier-save',              'CarrierController@save');
        Route::get('carrier-view/{id}',          'CarrierController@view')->where(['id' => '[0-9]+']);
        Route::post('carrier-delete/{id}',       'CarrierController@delete')->where(['id' => '[0-9]+']);

        //Слайдер
        Route::get('sliders-list',              'SliderController@list');
        Route::post('slider-save',              'SliderController@save');
        Route::get('slider-view/{id}',          'SliderController@view')->where(['id' => '[0-9]+']);
        Route::post('slider-delete/{id}',       'SliderController@delete')->where(['id' => '[0-9]+']);

        //тип оплаты
        Route::get('payments-list',              'PaymentController@list');
        Route::post('payment-save',              'PaymentController@save');
        Route::get('payment-view/{id}',          'PaymentController@view')->where(['id' => '[0-9]+']);
        Route::post('payment-delete/{id}',       'PaymentController@delete')->where(['id' => '[0-9]+']);

        //Статусы заказов
        Route::get('order-statuses-list',             'OrderStatusController@list');
        Route::post('order-status-save',              'OrderStatusController@save');
        Route::get('order-status-view/{id}',          'OrderStatusController@view')->where(['id' => '[0-9]+']);
        Route::post('order-status-delete/{id}',       'OrderStatusController@delete')->where(['id' => '[0-9]+']);

        //Скидки
        Route::get('specific-prices-list',             'SpecificPriceController@list');
        Route::post('specific-price-delete/{id}',      'SpecificPriceController@delete')->where(['id' => '[0-9]+']);

        //Обратный звонок
        Route::get('callbacks-list',             'CallbackController@list');
        Route::post('callback-delete/{id}',      'CallbackController@delete')->where(['id' => '[0-9]+']);
        Route::post('callback-save',             'CallbackController@save');
        Route::get('callback-view/{id}',         'CallbackController@view')->where(['id' => '[0-9]+']);
        Route::get('new-callbacks-count',        'CallbackController@newCallbacksCount');

        //Заказы
        Route::get('orders-list',                'OrderController@list');
        Route::get('order/{id}',                 'OrderController@view')->where(['id' => '[0-9]+']);
        Route::get('order/users',                'OrderController@users');
        Route::post('order-save',                'OrderController@orderSave');
        Route::post('order-delete/{order_id}',   'OrderController@orderDelete')->where(['order_id' => '[0-9]+']);
        Route::get('new-orders-count',           'OrderController@newOrdersCount');

        //статистика
        Route::get('full-calendar',                        'StatisticsController@fullCalendar');
        Route::get('highcharts-monthly-amount',            'StatisticsController@highchartsMonthlyAmount');
        Route::get('highcharts-monthly-amount-callbacks',  'StatisticsController@highchartsMonthlyAmountCallbacks');

        //компания
        Route::get('addresses-list',        'AddressController@list');

        //Группа атрибутов
        Route::get('attribute-groups-list',        'AttributeGroupController@list');

        //город
        Route::get('cities-list',             'CityController@list');
        Route::post('city-save',              'CityController@save');
        Route::get('city-view/{id}',          'CityController@view')->where(['id' => '[0-9]+']);
        Route::post('city-delete/{id}',       'CityController@delete')->where(['id' => '[0-9]+']);

        //баннеры
        Route::get('banners-list',             'BannerController@list');
        Route::post('banner-save',             'BannerController@save');
        Route::get('banner-view/{id}',         'BannerController@view')->where(['id' => '[0-9]+']);
        Route::post('banner-delete/{id}',      'BannerController@delete')->where(['id' => '[0-9]+']);

        //Статусы
        Route::post('statuses/{where_use}',    'StatusController@list')->where(['where_use' => '[0-9]+']);

        //Новости
        Route::get('news-list',               'NewsController@list');
        Route::post('news-save',              'NewsController@save');
        Route::get('news-view/{id}',          'NewsController@view')->where(['id' => '[0-9]+']);
        Route::post('news-delete/{id}',       'NewsController@delete')->where(['id' => '[0-9]+']);

    }
});

Auth::routes();
