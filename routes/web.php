<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtigoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AdminController;

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

Route::post('/artigos/{artigo}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store')->middleware('auth');
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy')->middleware('auth');

// Página de configuração do admin (pública)
Route::get('/admin/setup', function() {
    return view('admin.setup');
})->name('admin.setup');

// Rota de debug para verificar o status de administrador (temporária)
Route::get('/admin/check', function() {
    if (!auth()->check()) {
        return response()->json(['error' => 'Não autenticado'], 401);
    }
    
    $user = auth()->user();
    
    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'is_admin_raw' => $user->is_admin,
        'is_admin_method' => $user->isAdmin(),
        'all_attributes' => $user->toArray()
    ]);
})->middleware('auth');

// Rota de teste para verificar acesso de administrador
Route::get('/admin-test', function() {
    return view('admin.dashboard');
})->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);

// Rotas de administração
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/artigos', [AdminController::class, 'artigos'])->name('admin.artigos');
    Route::delete('/artigos/{id}', [AdminController::class, 'destroyArtigo'])->name('admin.artigos.destroy');
    Route::get('/utilizadores', [AdminController::class, 'utilizadores'])->name('admin.utilizadores');
    Route::put('/utilizadores/{id}/promover', [AdminController::class, 'promoverUtilizador'])->name('admin.utilizadores.promover');
    Route::put('/utilizadores/{id}/despromover', [AdminController::class, 'despromoverUtilizador'])->name('admin.utilizadores.despromover');
    Route::delete('/utilizadores/{id}', [AdminController::class, 'destroyUtilizador'])->name('admin.utilizadores.destroy');
    Route::get('/comentarios', [AdminController::class, 'comentarios'])->name('admin.comentarios');
    Route::delete('/comentarios/{id}', [AdminController::class, 'destroyComentario'])->name('admin.comentarios.destroy');
});

// Rota para deletar artigos (precisa estar autenticado e ser o dono do artigo)
Route::delete('/artigos/{id}', [ArtigoController::class, 'destroy'])->name('artigos.destroy')->middleware('auth');

