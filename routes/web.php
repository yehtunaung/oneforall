<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.frontend.app');
});


require __DIR__.'/backend.php';
require __DIR__.'/jetstream.php';
require __DIR__.'/fortify.php';
