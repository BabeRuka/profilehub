<?php

namespace BabeRuka\ProfileHub\Routes;

use Illuminate\Auth\Middleware\Authenticate;  
use BabeRuka\ProfileHub\Http\Controllers\AdminAjaxController;
use BabeRuka\ProfileHub\Http\Controllers\AdminController;
use BabeRuka\ProfileHub\Http\Controllers\AdminUserDetailsController;
use BabeRuka\ProfileHub\Http\Controllers\UserDetailsController;
use BabeRuka\ProfileHub\Http\Controllers\AdminUsersController;
use BabeRuka\ProfileHub\Http\Controllers\GroupController;
use BabeRuka\ProfileHub\Http\Controllers\ImportController;
use BabeRuka\ProfileHub\Http\Controllers\ProfileController;
use BabeRuka\ProfileHub\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route; 

Route::get('profilehub/index', [AdminController::class, 'index'])->name('profilehub.admin.index');
Route::prefix('profilehub')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('profilehub.dashboard');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('profilehub.admin');

        // Profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profilehub.admin.profile.index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profilehub.admin.profile.edit');
            Route::post('/createrecord', [ProfileController::class, 'createrecord'])->name('profilehub.admin.profile.createrecord');
            Route::get('/force', action: [ProfileController::class, 'force'])->name('profilehub.admin.profile.force');
            Route::post('/destroy', action: [ProfileController::class, 'destroy'])->name('profilehub.admin.profile.destroy');
            Route::post('/logoutruser', [ProfileController::class, 'logoutrUser'])->name('profilehub.admin.profile.logoutruser');
        });

        // Users routes
        Route::prefix('users')->group(function () {
            Route::get('/', [AdminUsersController::class, 'index'])->name('profilehub.admin.users');
            Route::get('/user', [ProfileController::class, 'index'])->name('profilehub.admin.users.user'); // Consider renaming
            Route::get('/edit', [UsersController::class, 'edit'])->name('profilehub.admin.users.user.edit');
            Route::get('/manage/roles', [AdminUsersController::class, 'roles'])->name('profilehub.admin.users.manage.roles');
            Route::get('/groups', [AdminUsersController::class, 'groups'])->name('profilehub.admin.users.groups');
            Route::post('/createrecord', [AdminUsersController::class, 'createrecord'])->name('profilehub.admin.users.createrecord');
            Route::get('/create', [UsersController::class, 'create'])->name('profilehub.admin.users.create');
            //Route::get('/import', [ImportController::class, 'import'])->name('profilehub.admin.users.import');
            //Route::post('/import/parse', [ImportController::class, 'parseImport'])->name('profilehub.admin.users.import.parse');
            //Route::post('/import/process', [ImportController::class, 'processImport'])->name('profilehub.admin.users.import.process');
            Route::post('/userdata', [AdminUsersController::class, 'userdata'])->name('profilehub.admin.users.userdata');
            Route::delete('/destroy', [UsersController::class, 'destroy'])->name('profilehub.admin.users.destroy');  
        });

        // User groups routes
        Route::prefix('groups')->group(function () {
            //Route::get('/index', [GroupController::class, 'index'])->name('profilehub.admin.groups.index');
            //Route::get('/users', [GroupController::class, 'users'])->name('profilehub.admin.groups.users');
            Route::get('/users/group', [AdminUsersController::class, 'group'])->name('profilehub.admin.users.groups.group');
            Route::post('/users/groups/createrecord', [AdminUsersController::class, 'createrecord'])->name('profilehub.admin.users.groups.createrecord');
            Route::get('/users/group users', [AdminUsersController::class, 'groupUsers'])->name('profilehub.admin.users.groups.groupusers'); // Consider renaming
            //Route::post('/createrecord', [GroupController::class, 'createrecord'])->name('profilehub.admin.users.groups.createrecord');
             Route::post('/group-users', [AdminAjaxController::class, 'getUserGroups'])->name('profilehub.admin.group.users'); 
             Route::post('/userdetails/createrecord', [UserDetailsController::class, 'createrecord'])->name('profilehub.admin.users.groups.userdetails.createrecord');
        });

        // Additional fields routes
        Route::prefix('users/profile')->group(function () {
            Route::get('/fields', [AdminUserDetailsController::class, 'index'])->name('profilehub.admin.users.profile.fields');
            Route::get('/field', [AdminUserDetailsController::class, 'userfield'])->name('profilehub.admin.users.profile.field');
            Route::get('/groups', [AdminUserDetailsController::class, 'groups'])->name('profilehub.admin.users.profile.groups');
            Route::get('/groups/children', [AdminUserDetailsController::class, 'children'])->name('profilehub.admin.users.profile.groups.children');
            Route::get('/groups/children/all', [AdminUserDetailsController::class, 'additionalFields'])->name('profilehub.admin.users.groups.children.all');
            Route::get('/groups/children/data', [AdminUserDetailsController::class, 'childrenData'])->name('profilehub.admin.users.profile.fields.groups.children.data');
            Route::get('/userdetails', [AdminUserDetailsController::class, 'index'])->name('profilehub.admin.users.userdetails.index');
            Route::get('/userfield', [AdminUserDetailsController::class, 'userfield'])->name('profilehub.admin.users.userdetails.field');
            Route::post('/userdetails/createrecord', [AdminUserDetailsController::class, 'createrecord'])->name('profilehub.admin.users.profile.userdetails.createrecord');
            Route::delete('/userdetails/destroy', [AdminUserDetailsController::class, 'destroy'])->name('profilehub.admin.users.profile.userdetails.destroy');
            Route::delete('/userdetails/destroyGroup', [AdminUserDetailsController::class, 'destroyGroup'])->name('profilehub.admin.users.profile.userdetails.destroyGroup');
            Route::post('/userdetails/manage', [AdminUserDetailsController::class, 'manage'])->name('profilehub.admin.users.profile.userdetails.manage');
            Route::get('/userdetails/manage/move', [AdminUserDetailsController::class, 'move'])->name('profilehub.admin.users.profile.userdetails.manage.move');
            Route::post('/userdetails/deleteData', [AdminUserDetailsController::class, 'deleteUserFieldData'])->name('profilehub.admin.users.profile.userdetails.deleteData');
        });

    });

});
