<?php

use Illuminate\Support\Facades\Route;

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
