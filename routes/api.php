<?php
Route::group([
    'middleware' => 'api'
], function () {
    //Login
    Route::post('me', 'AuthController@me');
    Route::post('login', 'AuthController@login');
    Route::post('loginsocial', 'AuthController@login_with_email');
    Route::post('logout', 'AuthController@logout');
    //Register
    Route::post('signup', 'AuthController@signup');
    Route::post('refresh', 'AuthController@refresh');
    //accounts
    Route::get('account', 'AccountController@list_account');
    Route::get('account/{id}', 'AccountController@edit_account');
    Route::post('account', 'AccountController@add_account');
    Route::put('account/{id}', 'AccountController@update_account');
    Route::delete('account/{id}', 'AccountController@delete_account');
    //coins

    Route::get('coin', 'CoinController@list_coin');
    Route::get('coin/{id}', 'CoinController@edit_coin');
    Route::put('coin/{id}', 'CoinController@update_coin');
    Route::post('coin', 'CoinController@add_coin');
    Route::delete('coin/{id}', 'CoinController@delete_coin');
    //expense
    Route::get('category', 'CategoryController@list_category');
    Route::get('category/{id}', 'CategoryController@edit_category');
    Route::post('category', 'CategoryController@add_category');
    Route::put('category/{id}', 'CategoryController@update_category');
    Route::delete('category/{id}', 'CategoryController@delete_category');
    //transactions
    Route::get('transacction', 'TransacctionController@list_transacction');
    //Route::get('reports', 'TransacctionController@list_reports');
    Route::post('transacction', 'TransacctionController@add_transacction');
    Route::put('transacction', 'TransacctionController@update_transacction');
    Route::delete('transacction/{id}', 'TransacctionController@delete_transacction');
    Route::post('transfer', 'TransacctionController@transfer');

    //reports
    Route::post('reports_between', 'ReportsController@reports_between');
});
