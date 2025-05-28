<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Log para debug
            \Log::debug('Utilizador autenticado:', [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'is_admin' => Auth::user()->is_admin,
                'isAdmin()' => Auth::user()->isAdmin()
            ]);
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Exibe o formulário para solicitar o link de redefinição de palavra-passe.
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Envia o e-mail com o link de recuperação de palavra-passe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Não encontrámos um utilizador com esse endereço de e-mail.']);
        }

        // Gerar token
        $token = Str::random(64);
        
        // Armazenar token no banco de dados
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Enviar email
        try {
            Mail::to($email)->send(new ResetPasswordMail($token, $email));
            
            // Registrar envio nos logs
            \Log::info("Email de recuperação de palavra-passe enviado para: " . $email);
            
            return back()->with('status', 'Enviámos um link de recuperação para o seu e-mail!');
        } catch (\Exception $e) {
            // Registrar erro nos logs
            \Log::error("Erro ao enviar email de recuperação: " . $e->getMessage());
            
            return back()->withErrors(['email' => 'Não foi possível enviar o e-mail de recuperação. Por favor, tente novamente mais tarde.']);
        }
    }

    /**
     * Exibe o formulário de redefinição de palavra-passe.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Redefine a palavra-passe do utilizador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Verificar se o token é válido
        $tokenData = \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Token inválido ou expirado.']);
        }

        // Verificar se o token não expirou (60 minutos)
        if (now()->diffInMinutes($tokenData->created_at) > 60) {
            return back()->withErrors(['email' => 'Token expirado. Por favor, solicite um novo link de redefinição.']);
        }

        // Atualizar a palavra-passe do utilizador
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Não encontrámos um utilizador com esse endereço de e-mail.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Remover o token usado
        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Log de sucesso
        \Log::info("Palavra-passe redefinida com sucesso para o utilizador: " . $user->email);

        return redirect()->route('login')->with('status', 'A sua palavra-passe foi redefinida com sucesso!');
    }
}
