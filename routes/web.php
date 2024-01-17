<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\NotationController;

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

Route::get('/monsters/register', [MonsterController::class, 'register'])->name('monster.register');

Route::post('/monsters/add', [MonsterController::class, 'add'])->middleware('auth')->name('monster.add');

Route::get('monsters/{id}/{slug}', function ($id) {
    return view('monster.show', ['monster' => \App\Models\Monster::find($id)]);
})->name('monsters.show');

Route::post('/rate-monster', [NotationController::class, 'store'])->name('monster.rate');

Route::get('/connection', function () {
    return view('pages.connection');
})->name('pages.connection');

Route::get('/users', function () {
    return view('user.index');
})->name('user.index');

Route::get('/users/register', function () {
    return view('user.register');
})->name('user.register');

Route::get('/user/edit', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');

Route::post('/user/add', [UserController::class, 'add'])->name('user.add');

Route::put('/update-profile', [UserController::class, 'update'])->middleware('auth')->name('user.update');

Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware('auth')->name('user.destroy');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('my-deck', function () {
    // Chargement des monstres favoris de l'utilisateur connecté
    $favorites = auth()->user()->favorites()->with('monster')->get();

    // Extraction des monstres de la collection de favoris
    $monsters = $favorites->map(function ($favorite) {
        return $favorite->monster;
    });
    return view('user.deck', ['monsters' => $monsters]);
})->middleware('auth')->name('user.deck');
