<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/', 'middleware' => ['auth', 'is_admin']], function () {
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/categories/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::post('/categories/toggle-status', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');
    Route::get('/categories/parents', [CategoryController::class, 'parents'])->name('category.parents');
    Route::get('/categories/list', [CategoryController::class, 'list'])->name('category.list');
    Route::post('/categories/update-order', [CategoryController::class, 'updateOrder'])->name('category.updateOrder');

    // Contacts
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{id}/delete', [ContactController::class, 'destroy'])->name('contacts.delete');
    Route::post('/contacts/toggle-status', [ContactController::class, 'toggleStatus'])->name('contacts.toggleStatus');

    // Company Details
    Route::get('/company-details', [CompanyDetailsController::class, 'index'])->name('admin.companyDetails');
    Route::post('/company-details', [CompanyDetailsController::class, 'update'])->name('admin.companyDetails.update');

    // Page SEO
    Route::get('/page-seo', [PageSeoController::class, 'index'])->name('page-seo.index');
    Route::post('/page-seo/update', [PageSeoController::class, 'update'])->name('page-seo.update');
    Route::get('/page-seo/{id}/edit', [PageSeoController::class, 'edit'])->name('page-seo.edit');
});