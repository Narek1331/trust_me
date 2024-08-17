<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ArticleController,
    SearchController,
    CommentController,
    TopController,
    ContactController,
    TermsController,
    PrivacyController,
    FeedbackController,
    UserController,
    InfoController
};
use App\Http\Controllers\News\{
    CategoryController,
    NewsController
};

Auth::routes(['verify' => true]);

Route::get('/', [ArticleController::class, 'index'])->name('welcome');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'search'], function () {
    Route::get('/{checkSlug}/{q}', [SearchController::class, 'index'])->name('search');
});

Route::group(['prefix'=>'top'], function () {
    Route::get('/', [TopController::class, 'index'])->name('top');
});

Route::group(['prefix'=>'news'], function () {
    Route::get('/', [NewsController::class, 'index'])->name('news');
    Route::get('/{id}', [NewsController::class, 'show'])->name('news.show');
});

Route::group(['prefix'=>'category'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('category.show');
});

Route::group(['prefix'=>'comment'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
    });
});

Route::group(['prefix'=>'profile','middleware'=>'auth'], function () {
    Route::put('/', [UserController::class, 'update'])->name('profile.update');
    Route::put('/password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::get('/comments', [UserController::class, 'comments'])->name('profile.comments');
    Route::get('/ratings', [UserController::class, 'ratings'])->name('profile.ratings');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/terms', [TermsController::class, 'index'])->name('terms');
Route::get('/privacy', [PrivacyController::class, 'index'])->name('privacy');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::group(['prefix'=>'info'], function () {
    Route::post('/', [InfoController::class, 'store'])->name('info.store');
});
