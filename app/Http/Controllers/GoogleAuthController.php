<?php

namespace App\Http\Controllers;
use App\Models\Utilizador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirecciona o utilizador para o Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Recebe os dados devolvidos pelo Google.
     */
    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $googleId = $googleUser->getId();
            $email = $googleUser->getEmail();
            $nome = $googleUser->getName();

            $emailVerificado = filter_var(
                $googleUser->user['verified_email']
                    ?? $googleUser->user['email_verified']
                    ?? false,
                FILTER_VALIDATE_BOOLEAN
            );

            if (!$googleId || !$email || !$emailVerificado) {
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Não foi possível confirmar a identidade ou o e-mail da conta Google.',
                    ]);
            }

            // Procurar uma conta já associada ao Google.
            $utilizador = Utilizador::where('google_id', $googleId)->first();

            if ($utilizador) {
                if (!$utilizador->isAtivo()) {
                    return redirect()->route('login')
                        ->withErrors([
                            'email' => 'A tua conta encontra-se inactiva.',
                        ]);
                }

                if ($utilizador->perfil !== 'cidadao') {
                    return redirect()->route('login')
                        ->withErrors([
                            'email' => 'Esta conta deve utilizar o acesso institucional.',
                        ]);
                }
            } else {
                // Procurar um cidadão pelo e-mail verificado.
                $utilizador = Utilizador::where('email', $email)->first();

                if ($utilizador) {
                    if (!$utilizador->isAtivo()) {
                        return redirect()->route('login')
                            ->withErrors([
                                'email' => 'A tua conta encontra-se inactiva.',
                            ]);
                    }

                    // Não associar automaticamente contas privilegiadas.
                    if ($utilizador->perfil !== 'cidadao') {
                        return redirect()->route('login')
                            ->withErrors([
                                'email' => 'Esta conta deve utilizar o acesso institucional.',
                            ]);
                    }

                    // Impedir associação a outra conta Google.
                    if ($utilizador->google_id !== null) {
                        return redirect()->route('login')
                            ->withErrors([
                                'email' => 'Esta conta já está associada a outra conta Google.',
                            ]);
                    }

                    $utilizador->google_id = $googleId;
                    $utilizador->save();
                } else {
                    // Criar uma nova conta de cidadão.
                    $utilizador = Utilizador::create([
                        'nome' => $nome ?: 'Cidadão',
                        'email' => $email,
                        'google_id' => $googleId,
                        'senha' => Hash::make(Str::random(64)),
                        'perfil' => 'cidadao',
                        'ativo' => 1,
                    ]);
                }
            }

            Auth::login($utilizador);

            $request->session()->regenerate();

            return redirect()->route('acompanhamento.index');

        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Não foi possível iniciar sessão com o Google. Tenta novamente.',
                ]);
        }
    }
}
