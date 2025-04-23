<?php

use App\Livewire\Backend\UserComponent;
use App\Livewire\Backend\PermissionComponent;
use App\Livewire\Backend\RoleComponent;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum',config('jetstream.auth_session'), 'verified',])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('backend/dashboard');
    })->name('dashboard');
    Route::get('users/{action?}/{id?}',UserComponent::class)->name('user');

    Route::get('permission/{action?}/{id?}',PermissionComponent::class)->name('permission');

    Route::get('role/{action?}/{id?}',RoleComponent::class)->name('role');

});


