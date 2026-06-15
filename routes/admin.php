<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyDetailsController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageSeoController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
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

    // Blogs
    Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blogs/update', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::post('/blogs/toggle-status', [BlogController::class, 'toggleStatus'])->name('blog.toggleStatus');
    Route::post('/blogs/update-order', [BlogController::class, 'updateOrder'])->name('blog.updateOrder');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('event.index');
    Route::post('/events', [EventController::class, 'store'])->name('event.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::post('/events/update', [EventController::class, 'update'])->name('event.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('event.delete');
    Route::post('/events/toggle-status', [EventController::class, 'toggleStatus'])->name('event.toggleStatus');
    Route::post('/events/update-order', [EventController::class, 'updateOrder'])->name('event.updateOrder');

    // Activities
    Route::get('/activities', [ActivityController::class, 'index'])->name('activity.index');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activity.edit');
    Route::post('/activities/update', [ActivityController::class, 'update'])->name('activity.update');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activity.delete');
    Route::post('/activities/toggle-status', [ActivityController::class, 'toggleStatus'])->name('activity.toggleStatus');
    Route::post('/activities/update-order', [ActivityController::class, 'updateOrder'])->name('activity.updateOrder');

    // Sliders
    Route::get('/sliders', [SliderController::class, 'index'])->name('slider.index');
    Route::post('/sliders', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
    Route::post('/sliders/update', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/sliders/{id}', [SliderController::class, 'destroy'])->name('slider.delete');
    Route::post('/sliders/toggle-status', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
    Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    // Programs
    Route::get('/programs', [ProgramController::class, 'index'])->name('program.index');
    Route::post('/programs', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/programs/{id}/edit', [ProgramController::class, 'edit'])->name('program.edit');
    Route::post('/programs/update', [ProgramController::class, 'update'])->name('program.update');
    Route::delete('/programs/{id}', [ProgramController::class, 'destroy'])->name('program.delete');
    Route::post('/programs/toggle-status', [ProgramController::class, 'toggleStatus'])->name('program.toggleStatus');
    Route::post('/programs/update-order', [ProgramController::class, 'updateOrder'])->name('program.updateOrder');

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('/testimonials/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::post('/testimonials/update', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.delete');
    Route::post('/testimonials/toggle-status', [TestimonialController::class, 'toggleStatus'])->name('testimonial.toggleStatus');
    Route::post('/testimonials/update-order', [TestimonialController::class, 'updateOrder'])->name('testimonial.updateOrder');

    // Teams
    Route::get('/teams', [TeamController::class, 'index'])->name('team.index');
    Route::post('/teams', [TeamController::class, 'store'])->name('team.store');
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('team.edit');
    Route::post('/teams/update', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('team.delete');
    Route::post('/teams/toggle-status', [TeamController::class, 'toggleStatus'])->name('team.toggleStatus');
    Route::post('/teams/update-order', [TeamController::class, 'updateOrder'])->name('team.updateOrder');

    // Galleries
    Route::get('/galleries', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/galleries/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::post('/galleries/update', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');
    Route::post('/galleries/toggle-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggleStatus');
    Route::post('/galleries/update-order', [GalleryController::class, 'updateOrder'])->name('gallery.updateOrder');

    Route::get('/galleries/{id}/media', [GalleryController::class, 'mediaList'])->name('gallery.media.list');
    Route::post('/galleries/media/bulk', [GalleryController::class, 'mediaBulkStore'])->name('gallery.media.bulk');
    Route::post('/galleries/media/youtube', [GalleryController::class, 'mediaYoutubeStore'])->name('gallery.media.youtube');
    Route::delete('/galleries/media/{id}', [GalleryController::class, 'mediaDestroy'])->name('gallery.media.delete');
    Route::post('/galleries/media/update-order', [GalleryController::class, 'mediaUpdateOrder'])->name('gallery.media.updateOrder');

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