<?php

use Belt\Content\Http\Controllers\Web;

Route::group(['middleware' => ['web']], function () {

    Route::get('docs', DocsController::class . '@index');
    Route::get('docs/{doc}', DocsController::class . '@show');

});