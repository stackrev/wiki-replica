<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\BlogController::class, 'home']);

Route::get('/post/new', function () {
    return view('post-form');
});

Route::post('/post/new', [App\Http\Controllers\BlogController::class, 'savePost']);
Route::post('/post/update', [App\Http\Controllers\BlogController::class, 'updatePost']);
Route::delete('/post/{item}', [App\Http\Controllers\BlogController::class, 'deletePost'])->name('post.delete');
Route::get('/post/{item}', [App\Http\Controllers\BlogController::class, 'getPost'])->name('post.edit');