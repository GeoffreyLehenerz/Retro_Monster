<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');

Route::get('/connection', function () {
    return view('pages.connection');
})->name('pages.connection');

Route::get('/monsters', function () {
    return view('monster.index');
})->name('monster.index');

Route::get('monsters/{id}/{slug}', function ($id) {
    return view('monster.show', ['monster' => \App\Models\Monster::find($id)]);
})->name('monsters.show');

Route::get('/users', function () {
    return view('user.index');
})->name('user.index');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
