<?php

use Framework\Facades\Route;

Route::get('/', 'index', 'IndexController@index');
Route::get('/user/{id}/{foo}/md', 'user','IndexController@user');
