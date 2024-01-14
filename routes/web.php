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

Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');


Route::get('/monsters', function () {
    return view('monster.index');
})->name('monster.index');

Route::get('monsters/{id}/{slug}', function ($id) {
    return view('monster.show', ['monster' => \App\Models\Monster::find($id)]);
})->name('monsters.show');

Route::get('/users', function () {
    return view('user.index');
})->name('user.index');
