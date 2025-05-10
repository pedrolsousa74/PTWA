<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;

// Página inicial
Route::get('/', function () {
    return view('home');
})->name('home');

// Controlador de artigos
Route::get('/artigos', [ArtigoController::class, 'artigos'])->name('artigos');
Route::get('/artigos/{id}', [ArtigoController::class, 'show'])->name('artigos.show');
Route::post('/artigos', [ArtigoController::class, 'store'])->middleware('auth')->name('artigos.store');

// Publicar artigo
Route::get('/escrever', function () {
    return view('publicar');
})->name('escrever');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard e Perfil
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth')->name('perfil');

// Página sobre
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');


Route::get('/artigos', [ArtigoController::class, 'index'])->name('artigos');

Route::post('/artigos/{id}/like', [ArtigoController::class, 'like'])->name('artigos.like');

Route::get('/', [ArtigoController::class, 'homepage'])->name('home');