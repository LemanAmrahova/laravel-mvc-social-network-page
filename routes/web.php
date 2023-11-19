<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginregisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AppealController;


Route::get('/',[PostController::class, 'index'])->name('posts.index');

//logout
Route::get('/logout',[LoginregisterController::class, 'logout'] )->name('logout');

Route::middleware(['checklogin'])->group(function () {

    //add
    Route::get('/addpost', [PostController::class, 'create'])->name('posts.create');
    Route::post('/addpost', [PostController::class, 'store'])->name('posts.store');

    //edit
    Route::get('/update/{id?}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');

    //delete
    Route::get('/delete/{id?}', [PostController::class, 'delete'])->name('delete');

    //likes
    Route::post('/like/{post}', [LikeController::class, 'store'])->name('likes.store');

    Route::get('/myposts', [PostController::class, 'myposts'])->name('posts.myposts');

    Route::post('/addcomments/{id}', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/deletecomment/{id?}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/addcompany', [CompanyController::class, 'create'])->name('companies.create');
    Route::post('/addcompany', [CompanyController::class, 'store'])->name('companies.store');

    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');

    Route::get('/addannouncement', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/addannouncement', [AnnouncementController::class, 'store'])->name('announcements.store');

    Route::get('/appeals/accept/{id}', [AppealController::class, 'accept'])->name('accept');
    Route::get('/appeals/decline/{id}', [AppealController::class, 'decline'])->name('decline');

    Route::get('/appeals/{announcement_id}', [AppealController::class, 'index'])->name('appeals.index');
    Route::post('/appeals', [AppealController::class, 'store'])->name('appeals.store');
});

Route::middleware(['guest'])->group(function () {
    //register
    Route::get('/register',[LoginregisterController::class, 'register'] )->name('register');
    Route::post('/register',[LoginregisterController::class, 'registerPost'] )->name('register');

    // login
    Route::get('/login',[LoginregisterController::class, 'login'] )->name('login');
    Route::post('/login',[LoginregisterController::class, 'loginPost'] )->name('login');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/postdetails/{post}/{id?}', [CommentController::class, 'index'])->name('posts.details');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');



