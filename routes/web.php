<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ComentarioController;

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

// Rota para editar artigo
Route::get('/artigos/{id}/editar', [ArtigoController::class, 'edit'])->middleware('auth')->name('artigos.edit');
Route::put('/artigos/{id}', [ArtigoController::class, 'update'])->middleware('auth')->name('artigos.update');

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

Route::post('/artigos/{id}/like', [ArtigoController::class, 'like'])->name('artigos.like')->middleware('auth');

Route::post('/artigos/{artigo}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');

// Rota para deletar artigos (precisa estar autenticado e ser o dono do artigo)
Route::delete('/artigos/{id}', [ArtigoController::class, 'destroy'])->name('artigos.destroy')->middleware('auth');

