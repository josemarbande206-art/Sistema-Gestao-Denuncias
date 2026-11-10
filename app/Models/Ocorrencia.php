<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table = 'ocorrencias';

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'titulo',
        'descricao',
        'data_ocorrencia',
        'estado',
        'utilizador_id',
        'operador_id',
        'categoria_id',
        'bem_publico_id',
        'localizacao_id',
    ];
}
