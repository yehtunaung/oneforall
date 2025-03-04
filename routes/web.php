<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.layouts.app');
});


require __DIR__.'/backend.php';
require __DIR__.'/jetstream.php';
require __DIR__.'/fortify.php';
