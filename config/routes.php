<?php

use Framework\Facades\Route;

Route::get('/', 'index', function () {
    return 'hello';
});

Route::get('/profile/{id}', 'profile', function ($id) {
    return 'User ' . $id;
});
