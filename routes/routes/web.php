<?php

//загрузить файл
Route::post('ckeditor-upload-image',   'UploadImageController@CkeditorUploadImage');

//выход
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//clear cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

//YANDEX
Route::group(['namespace'  => 'Yandex', 'as' => 'yandex.'], function () {
    Route::get('market-export.xml', 'MarketExportController@marketExport');
});




