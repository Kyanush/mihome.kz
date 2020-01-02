<?php
// Admin Interface
Route::group(['middleware' => ['role:admin'], 'prefix'     => 'admin', 'namespace'  => 'Admin'], function () {

    Route::get('report-goods/{format}',          'ReportController@goods');
    Route::get('yandex-directory/{format}',      'ReportController@yandexDirectory');
    Route::get('export-table/{table}',           'ExportController@exportTable')->where(['table']);

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

        Route::any('products-list',                  'ProductController@list');
        Route::post('product-save',                  'ProductController@save');
        Route::get('product-view/{id}',              'ProductController@view')->where(['id' => '[0-9]+']);
        Route::post('product-delete/{id}',           'ProductController@delete')->where(['id' => '[0-9]+']);
        Route::post('product-price-min-max',         'ProductController@priceMinMax');
        Route::post('products-attributes-filters',   'ProductController@productsAttributesFilters');

        Route::post('clone-product',                 'ProductController@cloneProduct');
        Route::get('search-products',                'ProductController@searchProducts');
        Route::post('products-selected-edit',        'ProductController@productsSelectedEdit');
        Route::post('product-change-quickly-save',   'ProductController@productChangeQuicklySave');
        Route::post('product-import',                'ProductController@import');

        Route::group(['prefix'     => 'product-attribute'], function () {
            Route::post('save',                         'ProductAttributeController@save');
            Route::post('get/{product_id}',             'ProductAttributeController@get')->where(['product_id' => '[0-9]+']);
        });

        Route::post('import',                        'ImportController@import');
        Route::get('table-list',                     'ImportController@tableList');
        Route::get('table-columns/{table}',          'ImportController@tableColumns')->where(['table']);


        //отзывы
        Route::get('reviews',                'ReviewController@list');
        Route::delete('review/{review_id}',  'ReviewController@delete')->where(['review_id' => '[0-9]+']);
        Route::post('review',                'ReviewController@save');
        Route::get('review/{review_id}',     'ReviewController@get')->where(['review_id' => '[0-9]+']);


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
        Route::group(['prefix'     => 'status'], function () {
            Route::get('callbacks-status-id', 'StatusController@callbacksStatusId');
            Route::get('orders-type',         'StatusController@ordersType');
            Route::get('list',                'StatusController@list');
        });

        //Новости
        Route::get('news-list',               'NewsController@list');
        Route::post('news-save',              'NewsController@save');
        Route::get('news-view/{id}',          'NewsController@view')->where(['id' => '[0-9]+']);
        Route::post('news-delete/{id}',       'NewsController@delete')->where(['id' => '[0-9]+']);

        //Настройки
        Route::post('save-settings',    'SettingController@saveSetting');
        Route::get('get-settings',      'SettingController@getSetting');

    }
});
