<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilizador;

class CriarAdministrador extends Command
{
    protected $signature = 'app:criar-administrador';

    protected $description = 'Cria a conta inicial do administrador';

    public function handle()
    {
        $email = 'josemarbande206@gmail.com';

        if (Utilizador::where('email', $email)->exists()) {
            $this->error('Já existe uma conta com este e-mail.');
            return self::FAILURE;
        }

        $senha = $this->secret('Introduza a palavra-passe:');

        if (!$senha || strlen($senha) < 8) {
            $this->error('A palavra-passe deve ter pelo menos 8 caracteres.');
            return self::FAILURE;
        }

        $confirmacao = $this->secret('Confirme a palavra-passe:');

        if ($senha !== $confirmacao) {
            $this->error('As palavras-passe não coincidem.');
            return self::FAILURE;
        }

        Utilizador::create([
            'nome' => 'Josemar Bande',
            'email' => $email,
            'senha' => Hash::make($senha),
            'perfil' => 'administrador',
        ]);

        $this->info('Administrador criado com sucesso!');

        return self::SUCCESS;
    }
}
