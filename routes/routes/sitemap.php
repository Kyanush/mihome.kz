<?php
//sitemap
Route::group(['namespace'  => 'Sitemap', 'as' => 'sitemap.'], function () {

    Route::get('sitemap.xml', 'SitemapController@sitemap');
    Route::get('pages.xml',   'SitemapController@pages')->name('pages');
    Route::get('news.xml',    'SitemapController@news')->name('news');

    $cities     = \App\Services\ServiceCity::listActiveSort();
    foreach ($cities as $city)
        Route::get($city->code . '.xml',   'SitemapController@city')->name($city->code);

});
