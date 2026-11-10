@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2>Registar Evidência</h2>
        <p class="text-muted">Associar uma fotografia ou documento a uma denúncia.</p>
    </div>

    <div class="card">
        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($ocorrencias->isEmpty())
                <div class="alert alert-warning">
                    Ainda não existem denúncias registadas. Regista primeiro uma denúncia.
                </div>
            @else

                <form action="{{ route('evidencias.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Seleccionar denúncia</label>

                        <select name="ocorrencia_id" class="form-select" required>
                            <option value="">Seleccione uma denúncia</option>

                            @foreach($ocorrencias as $ocorrencia)
                                <option value="{{ $ocorrencia->id }}"
                                    {{ old('ocorrencia_id') == $ocorrencia->id ? 'selected' : '' }}>

                                    {{ $ocorrencia->codigo }} - {{ $ocorrencia->titulo }}

                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Seleccionar ficheiro</label>

                        <input type="file"
                               name="arquivo"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp,.pdf"
                               required>

                        <small class="text-muted">
                            Formatos permitidos: JPG, JPEG, PNG, WEBP e PDF.
                            Tamanho máximo: 5 MB.
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Guardar Evidência
                        </button>

                        <a href="{{ route('evidencias.index') }}"
                           class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>

                </form>

            @endif

        </div>
    </div>

</div>

@endsection
