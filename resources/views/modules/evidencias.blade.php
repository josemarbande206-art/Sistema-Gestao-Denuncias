@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Gestão de Evidências</h2>
            <p class="text-muted">Consultar e gerir os ficheiros associados às denúncias.</p>
        </div>

        <a href="{{ route('evidencias.create') }}" class="btn btn-primary">
            + Registar Evidência
        </a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    @if(session('erro'))
        <div class="alert alert-danger">
            {{ session('erro') }}
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('evidencias.index') }}" method="GET">
                <div class="input-group">
                    <input type="text"
                           name="pesquisa"
                           class="form-control"
                           placeholder="Pesquisar por ficheiro, código ou denúncia..."
                           value="{{ $pesquisa }}">

                    <button class="btn btn-primary" type="submit">
                        Pesquisar
                    </button>

                    <a href="{{ route('evidencias.index') }}" class="btn btn-secondary">
                        Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Total de evidências: {{ $total }}
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Denúncia</th>
                        <th>Ficheiro</th>
                        <th>Tipo</th>
                        <th>Data de envio</th>
                        <th>Acções</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($evidencias as $evidencia)
                        <tr>
                            <td>{{ $evidencia->id }}</td>

                            <td>
                                <strong>{{ $evidencia->codigo }}</strong><br>
                                {{ $evidencia->titulo }}
                            </td>

                            <td>{{ $evidencia->nome_arquivo }}</td>

                            <td>{{ $evidencia->tipo_arquivo ?? 'Não definido' }}</td>

                            <td>{{ $evidencia->data_envio }}</td>

                            <td>
                                <a href="{{ asset('storage/' . $evidencia->caminho_arquivo) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-success">
                                    Visualizar
                                </a>

                                <form action="{{ route('evidencias.destroy', $evidencia->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tens a certeza de que pretendes eliminar esta evidência?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Nenhuma evidência encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $evidencias->links() }}

        </div>
    </div>

</div>

@endsection
