<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

define('pages_count', 5);
##################### main lang route ######################





Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {


    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
        Route::get('/', 'DashboardController@index')->name('index');
        Route::get('/welcome', 'DashboardController@index')->name('welcome');

        //users route
        Route::resource('users', 'UserController')->except(['show']);

        //Client route
        Route::resource('clients', 'ClientsController')->except(['show']);//main client

        Route::resource('clients.orders', 'client\OrderController')->except(['show']); // order client
        //End Of Client Route

        //Categories Route
        Route::resource('categories', 'CategoriesController')->except(['show']);
        //End Of Catigories Route

        //Products Route
        Route::resource('products', 'ProductsController')->except(['show']);
        //End Of Products Route

        //Order Route
        Route::resource('orders', 'OrderController')->except(['show']);
        Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');
        //End Of Order Route


    });
});













    // ->prefix("dashboard")
