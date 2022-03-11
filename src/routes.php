<?php
use Illuminate\Support\Facades\Route;

// Route::get('greeting', function () {
//     return 'Hi, this is your awesome package! mtw';
// });

// Route::get('mtw/test', 'EdgeWizz\Mtw\Controllers\MtwController@test')->name('test');

Route::post('fmt/mtw/store', 'EdgeWizz\Mtw\Controllers\MtwController@store')->name('fmt.mtw.store');
Route::post('fmt/mtw/update/{id}', 'EdgeWizz\Mtw\Controllers\MtwController@update')->name('fmt.mtw.update');
Route::any('fmt/mtw/delete/{id}', 'EdgeWizz\Mtw\Controllers\MtwController@delete')->name('fmt.mtw.delete');

Route::post('fmt/mtw/csv', 'EdgeWizz\Mtw\Controllers\MtwController@csv_upload')->name('fmt.mtw.csv');

Route::any('fmt/mtw/inactive/{id}',  'EdgeWizz\Mtw\Controllers\MtwController@inactive')->name('fmt.mtw.inactive');
Route::any('fmt/mtw/active/{id}',  'EdgeWizz\Mtw\Controllers\MtwController@active')->name('fmt.mtw.active');

