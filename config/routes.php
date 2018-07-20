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
})->where(['id' => '[a-z]+']);

Route::get('/profile/{id}/{de}', 'profileij', function ($id, $de) {
    return 'Useijijiijr ' . $id . $de;
})->where(['id' => '[0-9]+', 'de' => '[a-zA-Z]']);

Route::get('/profile/{id}/{de}/{er}/{des}', 'prttofileij', function ($id) {
    return 'Useijijiijr ' . $id;
})->where(['id' => '[0-9]+', 'de' => '[a-z]+', 'er' => '[\w]']);
