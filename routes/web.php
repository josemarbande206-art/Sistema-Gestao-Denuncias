<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\LocalizacaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AcompanhamentoController;
use App\Http\Controllers\BemPublicoController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\GestaoDenunciasController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'mostrarLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.autenticar');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $total = DB::table('ocorrencias')->count();

    $pendentes = DB::table('ocorrencias')
        ->where('estado', 'pendente')
        ->count();

    $emAnalise = DB::table('ocorrencias')
        ->where('estado', 'em_analise')
        ->count();

    $confirmadas = DB::table('ocorrencias')
        ->where('estado', 'confirmada')
        ->count();

    $resolvidas = DB::table('ocorrencias')
        ->where('estado', 'resolvida')
        ->count();

    $rejeitadas = DB::table('ocorrencias')
        ->where('estado', 'rejeitada')
        ->count();

    $recentes = DB::table('ocorrencias')
        ->leftJoin(
            'categorias',
            'ocorrencias.categoria_id',
            '=',
            'categorias.id'
        )
        ->select(
            'ocorrencias.id',
            'ocorrencias.codigo',
            'ocorrencias.titulo',
            'ocorrencias.data_registo',
            'ocorrencias.estado',
            'categorias.nome as categoria'
        )
        ->orderByDesc('ocorrencias.id')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'total',
        'pendentes',
        'emAnalise',
        'confirmadas',
        'resolvidas',
        'rejeitadas',
        'recentes'
    ));
})->middleware(['auth', 'perfil:administrador'])
  ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Registo e consulta de denúncias
|--------------------------------------------------------------------------
*/

Route::get('/denuncias/criar', [
    DenunciaController::class,
    'create'
])->name('denuncias.create');

Route::post('/denuncias', [
    DenunciaController::class,
    'store'
])->name('denuncias.store');

Route::get('/denuncias', [
    DenunciaController::class,
    'index'
])
->middleware(['auth', 'perfil:administrador,operador'])
->name('denuncias.index');

/*
|--------------------------------------------------------------------------
| Gestão de denúncias pelo operador
|--------------------------------------------------------------------------
*/

Route::prefix('gestao/denuncias')
    ->name('gestao.denuncias.')
    ->controller(GestaoDenunciasController::class)
    ->middleware(['auth', 'perfil:administrador,operador'])
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/{id}', 'show')
            ->whereNumber('id')
            ->name('show');

        Route::patch('/{id}/estado', 'atualizarEstado')
            ->whereNumber('id')
            ->name('estado');

    });

/*
|--------------------------------------------------------------------------
| Gestão de bens públicos
|--------------------------------------------------------------------------
*/

Route::prefix('bens-publicos')
    ->name('bens-publicos.')
    ->controller(BemPublicoController::class)
    ->middleware(['auth', 'perfil:administrador'])
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/criar', 'create')->name('create');

        Route::post('/', 'store')->name('store');

        Route::get('/{id}/editar', 'edit')
            ->whereNumber('id')
            ->name('edit');

        Route::put('/{id}', 'update')
            ->whereNumber('id')
            ->name('update');

        Route::delete('/{id}', 'destroy')
            ->whereNumber('id')
            ->name('destroy');

    });

/*
|--------------------------------------------------------------------------
| Acompanhamento de denúncias
|--------------------------------------------------------------------------
*/

Route::get(
    '/acompanhamento',
    [AcompanhamentoController::class, 'index']
)->name('acompanhamento.index');

/*
|--------------------------------------------------------------------------
| Módulos que serão implementados progressivamente
|--------------------------------------------------------------------------
*/

$modulos = [

    'historico' => [
        'uri' => '/historico',
        'nome' => 'Histórico de denúncias',
    ],

    'relatorios' => [
        'uri' => '/relatorios',
        'nome' => 'Relatórios e estatísticas',
    ],

    'utilizadores' => [
        'uri' => '/utilizadores',
        'nome' => 'Gestão de utilizadores',
    ],

    'operadores' => [
        'uri' => '/operadores',
        'nome' => 'Gestão de operadores',
    ],

    'auditoria' => [
        'uri' => '/auditoria',
        'nome' => 'Auditoria do sistema',
    ],

    'configuracoes' => [
        'uri' => '/configuracoes',
        'nome' => 'Configurações do sistema',
    ],

];

/*
|--------------------------------------------------------------------------
| Rotas temporárias dos módulos ainda não implementados
|--------------------------------------------------------------------------
*/

foreach ($modulos as $slug => $modulo) {

    Route::get($modulo['uri'], function () use ($modulo) {

        return view('modules.placeholder', [
            'titulo' => $modulo['nome'],
        ]);

       })->middleware(['auth', 'perfil:administrador'])
      ->name($slug . '.index');

}
/*
|--------------------------------------------------------------------------
| Gestão de categorias
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'perfil:administrador'])->group(function () {

    Route::get('/categorias', [CategoriaController::class, 'index'])
        ->name('categorias.index');

    Route::get('/categorias/criar', [CategoriaController::class, 'create'])
        ->name('categorias.create');

    Route::post('/categorias', [CategoriaController::class, 'store'])
        ->name('categorias.store');

    Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit'])
        ->whereNumber('id')
        ->name('categorias.edit');

    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])
        ->whereNumber('id')
        ->name('categorias.update');

    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])
        ->whereNumber('id')
        ->name('categorias.destroy');

});
/*
|--------------------------------------------------------------------------
| Gestão de localizações
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'perfil:administrador'])->group(function () {

    Route::get('/localizacoes', [LocalizacaoController::class, 'index'])
        ->name('localizacoes.index');

    Route::get('/localizacoes/criar', [LocalizacaoController::class, 'create'])
        ->name('localizacoes.create');

    Route::post('/localizacoes', [LocalizacaoController::class, 'store'])
        ->name('localizacoes.store');

    Route::get('/localizacoes/{id}/editar', [LocalizacaoController::class, 'edit'])
        ->whereNumber('id')
        ->name('localizacoes.edit');

    Route::put('/localizacoes/{id}', [LocalizacaoController::class, 'update'])
        ->whereNumber('id')
        ->name('localizacoes.update');

    Route::delete('/localizacoes/{id}', [LocalizacaoController::class, 'destroy'])
        ->whereNumber('id')
        ->name('localizacoes.destroy');

});
/*
|--------------------------------------------------------------------------
| Gestão de evidências
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'perfil:administrador'])->group(function () {

    Route::get('/evidencias', [EvidenciaController::class, 'index'])
        ->name('evidencias.index');

    Route::get('/evidencias/criar', [EvidenciaController::class, 'create'])
        ->name('evidencias.create');

    Route::post('/evidencias', [EvidenciaController::class, 'store'])
        ->name('evidencias.store');

    Route::delete('/evidencias/{id}', [EvidenciaController::class, 'destroy'])
        ->whereNumber('id')
        ->name('evidencias.destroy');

});
