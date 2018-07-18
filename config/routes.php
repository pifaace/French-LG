<?php

use Framework\Facades\Route;

Route::get('/', 'index', function () {
    return 'hello from index';
});

Route::get('/contact', 'contact', function () {
    return 'hello from contact';
});

Route::get('/profile/{id}', 'profile', function ($id) {
    return 'User ' . $id;
});
