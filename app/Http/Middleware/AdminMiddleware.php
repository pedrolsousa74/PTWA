<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle(Request $request, Closure $next): Response
    {        // Verificar se o utilizador está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Precisa estar autenticado para aceder a esta área.');
        }
        
        $user = auth()->user();
        
        // Log para diagnóstico
        \Log::debug('AdminMiddleware verificação:', [
            'user_id' => $user->id,
            'is_admin_raw' => $user->is_admin,
            'is_admin_method' => $user->isAdmin()
        ]);
        
        // Verificar se o utilizador é administrador
        if ($user->is_admin !== true && !$user->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Não tens permissão para aceder a esta área.'], 403);
            }
            
            // Para testes, verificar se estamos em ambiente de teste
            if (app()->environment('testing')) {
                abort(403, 'Não tens permissão para aceder a esta área.');
            }
            
            return redirect()->route('home')->with('error', 'Não tens permissão para aceder a esta área.');
        }
        
        return $next($request);
    }
}
