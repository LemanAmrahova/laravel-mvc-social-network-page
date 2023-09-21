<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginregisterController;
use App\Http\Controllers\PostController;

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
    Route::post('/like/{post}', [PostController::class, 'like'])->name('like');

    Route::get('/myposts', [PostController::class, 'myposts'])->name('myposts');

    Route::post('/addcomments/{id}', [PostController::class, 'addcomments'])->name('addcomments');

    Route::get('/deletecomment/{id?}', [PostController::class, 'deletecomment'])->name('deletecomment');
});

Route::get('/posts', [PostController::class, 'posts'])->name('posts');
Route::get('/postdetails/{post}/{id?}', [PostController::class, 'comments'])->name('postdetails');

