<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| Enjoy building your API!
|
*/

Route::prefix('bank')->group(function() {
    Route::get('get/{id}', 'Bank\MainController@getBankData');
});
