<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursesController;

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

Route::get('/create-user', [UserController::class, 'createUser'])->name('create-user');
Route::post('/create-user', [UserController::class, 'storeUser'])->name('store-user');

Route::get('/list-all-courses', [CoursesController::class, 'allCourses'])->name('list-all-courses');
Route::get('/filter-by-category', [CoursesController::class, 'filterByCategory'])->name('filter-by-category');
Route::get('/search-courses', [CoursesController::class, 'filterBySearch'])->name('filter-by-search');
Route::get('/create-courses', [CoursesController::class, 'createCourse'])->name('create-courses');
Route::post('/create-courses', [CoursesController::class, 'storeCourse'])->name('store-courses');
