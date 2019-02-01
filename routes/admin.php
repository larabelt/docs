<?php

Route::group([
    'prefix' => 'admin/belt/content',
    'middleware' => ['web', 'admin']
],
    function () {

        # admin/belt/content home
        Route::get('{any?}', function () {
            return view('belt-content::base.admin.dashboard');
        })->where('any', '(.*)');

    }
);