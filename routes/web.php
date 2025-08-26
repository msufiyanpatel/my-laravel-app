<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Backend\AddsController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PageBuilderController;
use App\Http\Controllers\Backend\UserManagementController;
use App\Http\Controllers\Backend\WebsiteSettingController;
use App\Http\Controllers\ImageHandlerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('dropzone/store', [ImageHandlerController::class, 'dropzoneStore'])->name('dropzone.store');
Route::post('convert', [ImageHandlerController::class, 'convertImages'])->name('convert');

Route::get('recent-images', [HomeController::class, 'recentImages'])->name('recent.images');
Route::get('delete-image/{id}', [HomeController::class, 'deleteImage'])->name('delete.image');

// dynamic pages 
Route::get('{slug}/page', [HomeController::class, 'dynamicPage'])->name('frontend.dynamic.page');

//authentication
Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::match(['get', 'post'], 'sign-up', [AuthController::class, 'signup'])->name('signup');
Route::match(['get', 'post'], 'forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::match(['get', 'post'], 'new-password', [AuthController::class, 'newPassword'])->name('new.password');
Route::match(['get', 'post'], 'password-reset', [AuthController::class, 'passwordReset'])->name('password.reset');
Route::get('resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');


// google auth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.handle.callback');


// ====================== /FRONTEND =====================

Route::get('dash-check', [AuthController::class, 'userDash'])->name('dashboard.redirect');
Route::get('user/auth-check', [AuthController::class, 'userAuthCheck'])->name('user.auth.check');
Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('user.update.profile')->middleware('auth');

// frontend.user.dashboard
Route::get('user/history', [UserDashboardController::class, 'index'])->name('frontend.user.dashboard');
Route::match(['get', 'post'], 'user/profile', [UserDashboardController::class, 'profile'])->name('frontend.user.profile')->middleware('auth');

// ====================== BACKEND =======================

// admin
Route::prefix('admin')->middleware(['admin'])->group(function () {

    Route::get('/', function () {
        return to_route('dashboard.redirect');
    });

    //profile
    Route::get('profile', [DashboardController::class, 'profile'])->name('backend.admin.profile');

    // page builder
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageBuilderController::class, 'index'])->name('backend.admin.pages');
        Route::post('create', [PageBuilderController::class, 'createPage'])->name('backend.admin.page.create');
        Route::get('fetch-data', [PageBuilderController::class, 'fetchPageData'])->name('backend.admin.page.data');
        Route::get('load-create-form', [PageBuilderController::class, 'loadCreateForm'])->name('backend.admin.page.load.create.form');
        Route::get('delete/{id}', [PageBuilderController::class, 'deletePage'])->name('backend.admin.delete.page');
        Route::get('load-edit-form', [PageBuilderController::class, 'loadEditForm'])->name('backend.admin.page.load.edit.form');
        Route::post('edit', [PageBuilderController::class, 'updatePage'])->name('backend.admin.update.page');
    });

    // user management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('backend.admin.users');
        Route::get('suspend/{id}/{status}', [UserManagementController::class, 'suspend'])->name('backend.admin.user.suspend');
        Route::get('history/{user_id}', [UserManagementController::class, 'history'])->name('backend.admin.user.history');
        Route::get('conversion-history', [UserManagementController::class, 'conversionHistory'])->name('backend.admin.conversion.history');
    });

    // settings
    Route::prefix('settings')->group(function () {
        // website settings
        Route::prefix('website')->group(function () {
            Route::controller(WebsiteSettingController::class)->prefix('general')->group(function () {
                Route::get('/', 'websiteGeneral')->name('backend.admin.settings.website.general');
                Route::post('update-info', 'websiteInfoUpdate')->name('backend.admin.settings.website.info.update');
                Route::post('update-social-links', 'websiteSocialLinkUpdate')->name('backend.admin.settings.website.social.link.update');
                Route::post('update-style-settings', 'websiteStyleSettingsUpdate')->name('backend.admin.settings.website.style.settings.update');
                Route::post('update-custom-css', 'websiteCustomCssUpdate')->name('backend.admin.settings.website.custom.css.update');
                Route::post('update-google-analytics', 'websiteGoogleAnalytics')->name('backend.admin.settings.website.google.analytics.update');
                Route::post('update-google-sign-up', 'websiteGoogleSignUp')->name('backend.admin.settings.website.google.sign.up.update');
            });
        });
    });

    // adds manager
    Route::prefix('adds')->group(function () {
        Route::get('/', [AddsController::class, 'index'])->name('backend.admin.adds');
        Route::post('update', [AddsController::class, 'update'])->name('backend.admin.adds.update');
    });
});

// ====================== /BACKEND ======================

Route::get('clear-all', function () {
    Artisan::call('optimize:clear');
    return redirect()->back();
});

Route::get('storage-link', function () {
    Artisan::call('storage:link');
    return redirect()->back();
});

Route::get('test', [TestController::class, 'test'])->name('test');
