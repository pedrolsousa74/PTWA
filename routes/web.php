<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;

// Página inicial
Route::get('/', function () {
    return view('home'); // Certifica-te de que tens um arquivo home.blade.php
})->name('home');

// Página de artigos
Route::get('/artigos', function () {
    return view('artigos'); // Criar artigos.blade.php
})->name('artigos');

// Página de escrever artigo
Route::get('/escrever', function () {
    return view('escrever'); // Criar escrever.blade.php
})->name('escrever');

// Página sobre
Route::get('/sobre', function () {
    return view('sobre'); // Criar sobre.blade.php
})->name('sobre');

// Página de login
Route::get('/login', function () {
    return view('login'); // Certifica-te de que tens auth/login.blade.php
})->name('login');

// Página de login
Route::get('/register', function () {
    return view('register'); // Certifica-te de que tens auth/register.blade.php
})->name('register');

Route::get('/escrever', function () {
    return view('publicar');
})->name('escrever');

Route::post('/artigos', function (Request $request) {
    // processar o artigo
})->middleware('auth')->name('artigos.store');

Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

Route::post('/artigos', [ArtigoController::class, 'store'])->name('artigos.store');

Route::get('/artigos', [ArtigoController::class, 'index'])->name('artigos');

Route::get('/artigos/{id}', [ArtigoController::class, 'show'])->name('artigos.show');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rota após login bem-sucedido
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');