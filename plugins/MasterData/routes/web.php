<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Now create something great!
|
*/

Route::prefix('master-data')->group(function () {
    Route::get('/', 'MasterDataController@index')->middleware('auth');
    

    Route::middleware(['permission:master.data_refBank'])->group(function () {
        Route::prefix('bank')->group(function() {
            Route::get('/', 'MasterDataController@getRefBank')->name('masterdata.refbank');
            Route::get('get/{id}', 'Bank\MainController@getBankData');
            Route::post('/', 'Bank\MainController@post');
            Route::put('/', 'Bank\MainController@put');
            Route::get('{id}/{checked}/delete', 'Bank\MainController@delete');
        });
    });

    Route::middleware(['permission:master.data_bankSecret'])->group(function () {
        Route::prefix('bank-secret')->group(function(){
            Route::get('/', 'MasterDataController@getBankSecret')->name('masterdata.bankSecret');
            Route::get('get-avail', 'BankSecret\MainController@getAvailBank');
            Route::post('/', 'BankSecret\MainController@post');
            Route::get('{id}/{checked}/delete', 'BankSecret\MainController@delete');
            Route::put('/', 'BankSecret\MainController@put');
        });
    });

    Route::middleware(['permission:master.data_bankEndpoint'])->group(function () {
        Route::prefix('bank-endpoint')->group(function(){
            Route::get('/', 'MasterDataController@getBankEndpoint')->name('masterdata.bankEndpoint');
            Route::get('get-banksecret', 'BankEndpoint\MainController@getBankSecret');
            Route::get('get-endpoint', 'BankEndpoint\MainController@getEndpointType');
            Route::post('/', 'BankEndpoint\MainController@post');
            Route::get('{id}/delete', 'BankEndpoint\MainController@delete');
            Route::put('/', 'BankEndpoint\MainController@put');
        });
    });
}); 
