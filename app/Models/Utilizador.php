<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilizador extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilizadores';

    public $timestamps = false;

protected $fillable = [
    'nome',
    'email',
    'telefone',
    'senha',
    'perfil',
    'ativo',
];

    protected $hidden = [
        'senha',
    ];

    /**
     * Indica ao Laravel qual é o campo da palavra-passe.
     */
    public function getAuthPassword(): string
    {
        return $this->senha;
    }
	public function isAtivo(): bool
{
    return (bool) $this->ativo;
}
}
