@extends('layout')

@section('conteudo')
    <h2></h2>
    <button class="btn btn-success mb-3" id="btnNovoRegistro">Novo Registro</button>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($animais as $animal)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @php
                        // Pega a primeira foto do animal ou usa placeholder
                        $foto = $animal->fotos->first()->caminho ?? 'sem-imagem.jpg';

                        // Calcula idade aproximada em anos
                        $idade = $animal->data_nascimento
                            ? \Carbon\Carbon::parse($animal->data_nascimento)->age
                            : 'Desconhecida';
                    @endphp

                    <img src="{{ asset('storage/' . $foto) }}" class="card-img-top"
                        alt="Foto de {{ $animal->nome }}" style="height: 180px; object-fit: cover;">

                    <!-- CORPO DO CARD COM AS INFORMAÇÕES -->
                    <div class="card-body">
                        <h5 class="card-title">{{ $animal->nome }}</h5>
                        <p class="card-text mb-1">
                            <strong>Idade:</strong> {{ is_numeric($idade) ? $idade . ' anos' : $idade }}
                        </p>
                        <p class="card-text">
                            <strong>Castrado:</strong> {{ $animal->castracao ? 'Sim' : 'Não' }}
                        </p>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('animais.show', $animal->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('animais.edit', $animal->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- MODAL (deve ficar FORA do foreach) -->
    <div id="modalAnimal" class="modal-overlay" style="display:none;">
        <div class="modal-animal">
            <button class="btn-close" onclick="fecharModal()">✖</button>
            <br>
            @include('animal.create')
        </div>
    </div>
@endsection