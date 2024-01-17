<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MonsterController;
use App\Http\Controllers\NotationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoritesController;

/*
|--------------------------------------------------------------------------
| Page Routes
|--------------------------------------------------------------------------
| Routes for basic page navigation
*/

// Page d'accueil
Route::get('/', function () {
    return view('pages.home');
})->name('pages.home');

// Liste de tous les monstres
Route::get('/monsters', function () {
    return view('monster.index');
})->name('monster.index');

// Connexion et inscription
Route::get('/connection', function () {
    return view('pages.connection');
})->name('pages.connection');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
| Routes for user registration, profile management, and authentication
*/

// Inscription des utilisateurs
Route::get('/users/register', function () {
    return view('user.register');
})->name('user.register');

// Profil de l'utilisateur et gestion
Route::get('/user/edit', [UserController::class, 'edit'])->middleware('auth')->name('user.edit');
Route::post('/user/add', [UserController::class, 'add'])->name('user.add');
Route::put('/update-profile', [UserController::class, 'update'])->middleware('auth')->name('user.update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->middleware('auth')->name('user.destroy');

// Authentification
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Deck de l'utilisateur
Route::get('my-deck', function () {
    // Chargement des monstres favoris de l'utilisateur connecté
    $favorites = auth()->user()->favorites()->with('monster')->get();
    $monsters = $favorites->map(function ($favorite) {
        return $favorite->monster;
    });
    return view('user.deck', ['monsters' => $monsters]);
})->middleware('auth')->name('user.deck');

/*
|--------------------------------------------------------------------------
| Monster Routes
|--------------------------------------------------------------------------
| Routes for managing monsters
*/

// Gestion des monstres
Route::get('/monster/gestion', [MonsterController::class, 'register'])->name('monster.management');
Route::post('/monster/manage', [MonsterController::class, 'manage'])->name('monster.manage');
Route::post('/monsters/add', [MonsterController::class, 'add'])->middleware('auth')->name('monster.add');
Route::put('/monster/update/{id}', [MonsterController::class, 'update'])->name('monster.update');
Route::delete('/monster/delete/{id}', [MonsterController::class, 'delete'])->name('monster.delete');

// Ajouter un monstre aux favoris
Route::post('/monster/addToFavorites/{monsterId}', [FavoritesController::class, 'addToFavorites'])->name('monster.add-to-favorites');

// Affichage d'un monstre spécifique
Route::get('monsters/{id}/{slug}', function ($id) {
    return view('monster.show', ['monster' => \App\Models\Monster::find($id)]);
})->name('monsters.show');

/*
|--------------------------------------------------------------------------
| Notation and Comment Routes
|--------------------------------------------------------------------------
| Routes for rating and commenting on monsters
*/

// Notation des monstres
Route::post('/rate-monster', [NotationController::class, 'store'])->name('monster.rate');

// Commentaires sur les monstres
Route::post('/monster/{monster}/comment', [CommentController::class, 'store'])->name('monster.comment');

/*
|--------------------------------------------------------------------------
| Misc Routes
|--------------------------------------------------------------------------
| Other miscellaneous routes
*/

// Liste des utilisateurs (pour l'administrateur ou autre usage)
Route::get('/users', function () {
    return view('user.index');
})->name('user.index');
