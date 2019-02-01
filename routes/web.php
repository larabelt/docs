<?php

//use Belt\Content\Http\Controllers\Web;
//
//Route::group(['middleware' => ['web']], function () {
//
//    Route::get('docs', DocsController::class . '@index');
//    Route::get('docs/{doc}', DocsController::class . '@show');
//
//});

Route::group([
    'prefix' => config('larecipe.docs.route'),
    'namespace' => 'BinaryTorch\LaRecipe\Http\Controllers',
    'as' => 'larecipe.',
    'middleware' => 'web'
], function () {
    Route::get('/', 'DocumentationController@index')->name('index');
    Route::get('/{version}/{path?}', 'DocumentationController@show')->where('path', '(.*)')->name('show');
});