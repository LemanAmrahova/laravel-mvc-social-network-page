<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginregisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AppealController;

//register
Route::get('/register',[LoginregisterController::class, 'register'] )->name('register');
Route::post('/register',[LoginregisterController::class, 'registerPost'] )->name('register');

// login logout
Route::get('/login',[LoginregisterController::class, 'login'] )->name('login');
Route::post('/login',[LoginregisterController::class, 'loginPost'] )->name('login');
Route::get('/logout',[LoginregisterController::class, 'logout'] )->name('logout');

Route::middleware(['checklogin'])->group(function () {

    //add
    Route::get('/addpost', [PostController::class, 'addpostGet'])->name('addpost');
    Route::post('/addpost', [PostController::class, 'addpost'])->name('addpost');

    //edit
    Route::get('/editpost/{id?}', [PostController::class, 'edit'])->name('editpost');
    Route::put('/editpost/{id}', [PostController::class, 'editpost'])->name('editpost');
    
    //delete
    Route::get('/delete/{id?}', [PostController::class, 'delete'])->name('delete');

    //likes
    Route::post('/like/{post}', [LikeController::class, 'like'])->name('like');

    Route::get('/myposts', [PostController::class, 'myposts'])->name('myposts');

    Route::post('/addcomments/{id}', [CommentController::class, 'addcomments'])->name('addcomments');

    Route::get('/deletecomment/{id?}', [CommentController::class, 'deletecomment'])->name('deletecomment');

    Route::get('/addcompany', [CompanyController::class, 'show'])->name('addcompany');
    Route::post('/addcompany', [CompanyController::class, 'store'])->name('addcompany');

    Route::get('/companies', [CompanyController::class, 'index'])->name('companies');
    
    Route::get('/addannouncement', [AnnouncementController::class, 'create'])->name('addannouncement');
    Route::post('/addannouncement', [AnnouncementController::class, 'store'])->name('addannouncement');

    Route::get('/appeals/accept/{id}', [AppealController::class, 'accept'])->name('accept');
    Route::get('/appeals/decline/{id}', [AppealController::class, 'decline'])->name('decline');

    Route::get('/appeals/{announcement_id}', [AppealController::class, 'index'])->name('appeals');
    Route::post('/appeals', [AppealController::class, 'store'])->name('addappeal');
});

Route::get('/posts', [PostController::class, 'posts'])->name('posts');
Route::get('/postdetails/{post}/{id?}', [CommentController::class, 'comments'])->name('postdetails');
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements');



