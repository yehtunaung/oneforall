<?php

use App\Livewire\Backend\UserComponent;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum',config('jetstream.auth_session'), 'verified',])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('backend/dashboard');
    })->name('dashboard');
    Route::get('user',UserComponent::class)->name('user');
});


