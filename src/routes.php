<?php
use Illuminate\Support\Facades\Route;

Route::get('greeting', function () {
    return 'Hi, this is your awesome package! lamas';
});

Route::get('lamas/test', 'EdgeWizz\lamas\Controllers\lamasController@test')->name('test');

Route::post('fmt/lamas/store', 'EdgeWizz\Lamas\Controllers\LamasController@store')->name('fmt.lamas.store');
Route::post('fmt/lamas/update/{id}', 'EdgeWizz\Lamas\Controllers\LamasController@update')->name('fmt.lamas.update');
Route::any('fmt/lamas/delete/{id}', 'EdgeWizz\Lamas\Controllers\LamasController@delete')->name('fmt.lamas.delete');

Route::post('fmt/lamas/csv', 'EdgeWizz\Lamas\Controllers\LamasController@csv_upload')->name('fmt.lamas.csv');

Route::any('fmt/lamas/inactive/{id}',  'EdgeWizz\Lamas\Controllers\LamasController@inactive')->name('fmt.lamas.inactive');
Route::any('fmt/lamas/active/{id}',  'EdgeWizz\Lamas\Controllers\LamasController@active')->name('fmt.lamas.active');

