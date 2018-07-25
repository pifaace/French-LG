<?php

use Framework\Facades\Route;

Route::get('/', 'index', 'IndexController@index');

Route::get('/contact', 'contact', function () {
    return 'hello from contact';
});
