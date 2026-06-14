<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Models\Ad;
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

require __DIR__ . '/admin.php';

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/category/{slug}', [FrontendController::class, 'category'])->name('category.show');

Route::get('/video', [FrontendController::class, 'video'])->name('video');

Route::get('/article/{slug}', [FrontendController::class, 'article'])->name('article.show');

Route::get('/tag/{slug}', [FrontendController::class, 'tag'])->name('tag.show');

Route::get('/search', [FrontendController::class, 'search'])->name('search');

Route::get('/epaper', [FrontendController::class, 'epaper'])->name('epaper');

Route::get('/live', [FrontendController::class, 'live'])->name('live');

Route::get('/archive', [FrontendController::class, 'archive'])->name('archive');

Route::get('/about', [FrontendController::class, 'about'])->name('about');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

Route::post('/contact', [FrontendController::class, 'contactStore'])->name('contact.store');

Route::get('/advertise', [FrontendController::class, 'advertise'])->name('advertise');

Route::get('/career', [FrontendController::class, 'career']) ->name('career');

Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');

Route::post('/newsletter', [FrontendController::class, 'newsletter'])->name('newsletter.subscribe');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

Route::get('/ad-click/{id}', function ($id) {
    $ad = Ad::findOrFail($id);
    $ad->increment('clicks');
    return redirect($ad->url);
})->name('ad.click');

Route::group(['prefix' => 'user/', 'middleware' => ['auth', 'is_user', 'verified']], function () {

    Route::get('/dashboard', [HomeController::class, 'userHome'])->name('user.dashboard');
});

Route::fallback(function () {
    return redirect('/');
});