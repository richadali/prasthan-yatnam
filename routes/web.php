<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/discourses', function () {
    return view('discourses.index');
});

Route::get('/poems', function () {
    return view('poems.index');
});

Route::get('/activity', function () {
    return view('activity.index');
});

Route::get('/testimonials', function () {
    return view('testimonials.index');
});

Route::get('/about', function () {
    return view('about.index');
});
