<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    Auth::logout();
    session()->flush();
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::fallback(function () {
    return redirect('/');
});

require __DIR__ . '/admin.php';

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/about', [FrontendController::class, 'about'])->name('about');

Route::get('/team', [FrontendController::class, 'team'])->name('team');

Route::get('/activities', [FrontendController::class, 'activities'])->name('activities');

Route::get('/activities/{slug}', [FrontendController::class, 'activityDetails'])->name('activity.details');

Route::get('/blogs', [FrontendController::class, 'blogs'])->name('blogs');

Route::get('/blogs/{slug}', [FrontendController::class, 'blogDetails'])->name('blog.details');

Route::get('/events', [FrontendController::class, 'events'])->name('events');

Route::get('/events/{slug}', [FrontendController::class, 'eventDetails'])->name('event.details');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::post('/contact', [FrontendController::class, 'contactStore'])->name('contact.store');

Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');

Route::get('/terms-and-conditions', [FrontendController::class, 'terms'])->name('terms');

Route::get('/frequently-asked-questions', [FrontendController::class, 'faq'])->name('faq');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::group(['prefix' => 'user/', 'middleware' => ['auth', 'is_user', 'verified']], function () {

    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');
    
});