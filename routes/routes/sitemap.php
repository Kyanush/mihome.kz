<?php
//sitemap
Route::group(['namespace'  => 'Sitemap', 'as' => 'sitemap.'], function () {

    Route::get('sitemap.xml',  'SitemapController@sitemap');
    Route::get('pages.xml',    'SitemapController@pages')->name('pages');
    Route::get('news.xml',     'SitemapController@news')->name('news');
    Route::get('products.xml', 'SitemapController@products')->name('products');

});