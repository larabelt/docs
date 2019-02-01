<?php

use Belt\Content\Http\Controllers\Web;

Route::group(['middleware' => ['web']], function () {

    Route::pattern('clippable_id', '[0-9]+');

    if (config('belt.core.translate.prefix-urls')) {
        foreach ((array) config('belt.core.translate.locales') as $locale) {
            $code = array_get($locale, 'code');
            Route::group([
                'prefix' => "$code/{clippable_type}/{clippable_id}/attachments",
                'middleware' => 'request.injections:clippable_type,clippable_id'
            ], function () {
                Route::get('{any?}', Web\ClippablesController::class . '@show')->where('any', '(.*)');
            });

            Route::get("$code/lists/{list}/{slug?}", Web\ListsController::class . '@show');
            Route::get("$code/pages/{page}/{slug?}", Web\PagesController::class . '@show');
            Route::get("$code/pages", function () {
                return view('belt-core::base.web.home');
            });
            Route::get("$code/posts/{post}/{slug?}", Web\PostsController::class . '@show');
            Route::get("$code/posts", function () {
                return view('belt-core::base.web.home');
            });
            Route::get("$code/search", Web\SearchController::class . '@index');
            Route::get("$code/sections/{section}/preview", Web\SectionsController::class . '@preview');
            Route::get("$code/terms/{term}", Web\TermsController::class . '@show');
            Route::get("$code/terms", function () {
                return view('belt-core::base.web.home');
            });
        }
    }

    Route::group([
        'prefix' => '{clippable_type}/{clippable_id}/attachments',
        'middleware' => 'request.injections:clippable_type,clippable_id'
    ], function () {
        Route::get('{any?}', Web\ClippablesController::class . '@show')->where('any', '(.*)');
    });

    Route::get('lists/{list}/{slug?}', Web\ListsController::class . '@show');
    Route::get('pages/{page}/{slug?}', Web\PagesController::class . '@show');
    Route::get('pages', function () {
        return view('belt-core::base.web.home');
    });
    Route::get('posts/{post}/{slug?}', Web\PostsController::class . '@show');
    Route::get('posts', function () {
        return view('belt-core::base.web.home');
    });
    Route::get('search', Web\SearchController::class . '@index');
    Route::get('sections/{section}/preview', Web\SectionsController::class . '@preview');
    Route::get('terms/{term}', Web\TermsController::class . '@show');
    Route::get('terms', function () {
        return view('belt-core::base.web.home');
    });

});