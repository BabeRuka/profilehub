<?php
declare(strict_types=1);

namespace BabeRuka\ProfileHub\Routes;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route; 
use BabeRuka\ProfileHub\Http\Controllers\AdminUsersController; 

Route::prefix('profilehub')->group(function () { 
    Route::post('/users/userdata', [AdminUsersController::class, 'userdata'])->name('admin.users.userdata');
});
