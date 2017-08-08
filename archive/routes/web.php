<?php

//use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group([
    'middleware' => ['auth.basic.once']
],
    function () {

        Route::get('docs', DocsController::class . '@index');
        Route::get('docs/{doc}', DocsController::class . '@show');

        Route::get('/', function () {
            return view('home.index');
        });
    }
);