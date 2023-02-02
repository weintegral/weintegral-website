<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return 'About Page';
});

Route::get('/services', function () {
    return 'Services Page';
});

Route::get('/clients', function () {
    return 'Clients Page';
});

Route::get('/team', function () {
    return 'Team Page';
});

Route::get('/industries', function () {
    return 'Industries that we serve Page';
});

Route::get('/blog', function () {
    return 'Blog Page';
});

Route::get('/career', function () {
    return 'Career Page';
});

Route::get('/career/work-culture', function () {
    return 'Work Culture Page';
});

Route::get('/career/benefits', function () {
    return 'Benefits Page';
});

Route::get('/career/openings', function () {
    return 'Current Openings Page';
});

Route::get('/contact', function () {
    return 'Contact Page';
});
