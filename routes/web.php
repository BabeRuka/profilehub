<?php

namespace BabeRuka\ProfileHub\Routes;

use Illuminate\Auth\Middleware\Authenticate;  
//use BabeRuka\ProfileHub\Http\Controllers\AdminAjaxController;
use BabeRuka\ProfileHub\Http\Controllers\AdminController;
use BabeRuka\ProfileHub\Http\Controllers\AdminCountriesController;
//use BabeRuka\ProfileHub\Http\Controllers\AdminCountryController;
use BabeRuka\ProfileHub\Http\Controllers\AdminLayoutController;
use BabeRuka\ProfileHub\Http\Controllers\AdminPageModulesController;
use BabeRuka\ProfileHub\Http\Controllers\AdminPagesController;
use BabeRuka\ProfileHub\Http\Controllers\AdminUserDetailsController;
use BabeRuka\ProfileHub\Http\Controllers\AdminUsersController;
use BabeRuka\ProfileHub\Http\Controllers\GroupController;
//use BabeRuka\ProfileHub\Http\Controllers\ImportController;
use BabeRuka\ProfileHub\Http\Controllers\ProfileController;
use BabeRuka\ProfileHub\Http\Controllers\UsersController;
use BabeRuka\ProfileHub\Http\Controllers\WidgetsController;
use Illuminate\Support\Facades\Route; 

Route::get('profilehub/index', [AdminPagesController::class, 'index'])->middleware([Authenticate::class])->name('profilehub.index');
Route::prefix('profilehub')->middleware([Authenticate::class])->group(function () {
    // All routes within this group will require authentication 
        // Dashboard
    Route::get('/dashboard', [AdminPagesController::class, 'index'])->name('profilehub.dashboard');
    //Route::get('/', [AdminPagesController::class, 'index'])->name('profilehub.index.root.redirect'); 

    Route::get('/country', [AdminCountriesController::class, 'index'])->name('profilehub.country');
    //Route::post('/ajax/validate', [AdminAjaxController::class, 'validateUserdetail'])->name('profilehub.ajax.userdetails.validate');
    Route::prefix('widgets')->group(function () {
        Route::get('/forms/getWidget', [WidgetsController::class, 'getFormWidget'])->name('profilehub.widgets.forms.getWidget');
    });

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('profilehub.admin.index');

        // Profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profilehub.admin.profile.index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profilehub.admin.profile.edit');
            Route::post('/createrecord', [ProfileController::class, 'createrecord'])->name('profilehub.admin.profile.createrecord');
            Route::get('/force', [ProfileController::class, 'force'])->name('profilehub.admin.profile.force');
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
            //Route::get('/users/group users', [GroupController::class, 'getUserGroups'])->name('profilehub.admin.users.groups.groupusers'); // Consider renaming
            //Route::post('/createrecord', [GroupController::class, 'createrecord'])->name('profilehub.admin.groups.createrecord');
        });

        // Additional fields routes
        Route::prefix('users/profile')->group(function () {
            Route::get('/fields', [AdminUserDetailsController::class, 'index'])->name('profilehub.admin.users.profile.fields');
            Route::get('/field', [AdminUserDetailsController::class, 'userfield'])->name('profilehub.admin.users.profile.field');
            Route::get('/groups', [AdminUserDetailsController::class, 'groups'])->name('profilehub.admin.users.profile.groups');
            Route::get('/groups/children', [AdminUserDetailsController::class, 'children'])->name('profilehub.admin.users.profile.groups.children');
            Route::get('/groups/children/data', [AdminUserDetailsController::class, 'childrenData'])->name('profilehub.admin.users.profile.fields.groups.children.data');
            Route::get('/userdetails', [AdminUserDetailsController::class, 'index'])->name('profilehub.admin.users.userdetails.index');
            Route::get('/userfield', [AdminUserDetailsController::class, 'userfield'])->name('profilehub.admin.users.userdetails.field');
            Route::post('/userdetails/createrecord', [AdminUserDetailsController::class, 'createrecord'])->name('profilehub.admin.users.profile.userdetails.createrecord');
            Route::delete('/userdetails/destroy', [AdminUserDetailsController::class, 'destroy'])->name('profilehub.admin.users.profile.userdetails.destroy');
            Route::delete('/userdetails/destroyGroup', [AdminUserDetailsController::class, 'destroyGroup'])->name('profilehub.admin.users.profile.userdetails.destroyGroup');
            Route::post('/userdetails/manage', [AdminUserDetailsController::class, 'manage'])->name('profilehub.admin.users.profile.userdetails.manage');
            Route::get('/userdetails/manage/move', [AdminUserDetailsController::class, 'move'])->name('profilehub.admin.users.profile.userdetails.manage.move');
        });

        // Layout routes
        Route::prefix('layout')->group(function () {
            Route::get('/', [AdminLayoutController::class, 'index'])->name('profilehub.admin.layout');
            Route::get('/widgets', [AdminLayoutController::class, 'widgets'])->name('profilehub.admin.layout.widgets');
            Route::get('/pages', [AdminLayoutController::class, 'pages'])->name('profilehub.admin.layout.pages');
            Route::get('/pages/preview', [AdminLayoutController::class, 'preview'])->name('profilehub.admin.layout.pages.preview');
            Route::get('/pages/userdashboard', [AdminLayoutController::class, 'userdashboard'])->name('profilehub.admin.layout.pages.userdashboard');
            Route::get('/pages/forceprofile', [AdminLayoutController::class, 'forceprofile'])->name('profilehub.admin.layout.pages.forceprofile');
            Route::get('/pages/registration', [AdminLayoutController::class, 'registration'])->name('profilehub.admin.layout.pages.registration');
            Route::post('/createrecord', [AdminLayoutController::class, 'createrecord'])->name('profilehub.admin.layout.createrecord');
            Route::get('/pages/edit', [AdminPagesController::class, 'edit'])->name('profilehub.admin.layout.pages.edit');
            Route::post('/pages/createrecord', [AdminPagesController::class, 'createrecord'])->name('profilehub.admin.layout.pages.createrecord');
            Route::get('/pages/getWidget', [AdminPagesController::class, 'getWidget'])->name('profilehub.admin.layout.pages.getWidget');
        });

        // Modules routes
        Route::prefix('modules')->group(function () {
            Route::get('/', [AdminPageModulesController::class, 'index'])->name('profilehub.admin.modules');
            Route::get('/index', [AdminPageModulesController::class, 'index'])->name('profilehub.admin.modules.index');
            Route::get('/groups', [AdminPageModulesController::class, 'groups'])->name('profilehub.admin.modules.groups');
            Route::post('/createrecord', [AdminPageModulesController::class, 'createrecord'])->name('profilehub.admin.modules.createrecord');
            Route::post('/update', [AdminPageModulesController::class, 'groups'])->name('profilehub.admin.modules.update');
            Route::post('/store', [AdminPageModulesController::class, 'store'])->name('profilehub.admin.modules.store');
        });

        // Countries routes
        Route::prefix('countries')->group(function () {
            Route::get('/', [AdminCountriesController::class, 'index'])->name('profilehub.admin.countries');
            Route::get('/index', [AdminCountriesController::class, 'index'])->name('profilehub.admin.countries.index');
            Route::post('/countryData', [AdminCountriesController::class, 'countryData'])->name('profilehub.admin.countries.data');
            Route::post('/createrecord', [AdminCountriesController::class, 'createrecord'])->name('profilehub.admin.countries.createrecord');
            Route::post('/update', [AdminCountriesController::class, 'groups'])->name('profilehub.admin.countries.update');
            Route::post('/store', [AdminCountriesController::class, 'store'])->name('profilehub.admin.countries.store');
            Route::post('/delete', [AdminCountriesController::class, 'delete'])->name('profilehub.admin.countries.delete');
        });

        /*
        Route::prefix('country')->group(function () {
            Route::get('/', [AdminCountryController::class, 'index'])->name('profilehub.admin.country');
            Route::get('/index', [AdminCountryController::class, 'index'])->name('profilehub.admin.country.index');
            Route::post('/countryData', [AdminCountryController::class, 'countryData'])->name('profilehub.admin.country.data');
            Route::post('/createrecord', [AdminCountryController::class, 'createrecord'])->name('profilehub.admin.country.createrecord');
            Route::post('/update', [AdminCountryController::class, 'groups'])->name('profilehub.admin.country.update');
            Route::post('/store', [AdminCountryController::class, 'store'])->name('profilehub.admin.country.store');
            Route::post('/delete', [AdminCountryController::class, 'delete'])->name('profilehub.admin.country.delete');
        });
        */
    });

    Route::prefix('widgets')->group(function () {
        Route::get('/forms/getWidget', [WidgetsController::class, 'getFormWidget'])->name('profilehub.widgets.forms.getWidget');
    });
});