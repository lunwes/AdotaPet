@extends('layout')

@section('conteudo')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Anúncios Salvos</h2>
    </div>

    @if($favoritos->count() > 0)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($favoritos as $favorito)
            <div class="col"> <!-- alteração -->
                    <div class="card h-100 shadow-sm"> <!-- alteração --> 
                @php
                    $foto = $animal->fotos->first();
                    $fotoUrl = $foto ? \App\Helpers\ImageHelper::url($foto->caminho) : asset('images/sem-imagem.jpg');
                    $animal = $favorito->animal;
                    $idade = $animal->idade_formatada;
                @endphp

                <img src="{{ $fotoUrl }}" class="card-img-top" alt="Foto de {{ $animal->nome }}">
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $foto) }}" class="card-img-top" alt="Foto de {{ $animal->nome }}"
                            style="height: 180px; object-fit: cover;">

                        <div class="card-body">
                            <h5 class="card-title">{{ $animal->nome }}</h5>
                            <p class="card-text mb-1">
                                <strong>Idade:</strong> {{ $idade }}
                            </p>
                            <p class="card-text">
                                <strong>Status:</strong>
                                <span class="badge {{ $animal->adotado ? 'bg-secondary' : 'bg-success' }}">
                                    {{ $animal->adotado ? 'Adotado' : 'Disponível' }}
                                </span>
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('animais.show', $animal->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <form action="{{ route('favoritar', $animal) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i> Remover
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-bookmark fs-1 text-muted"></i>
            <p class="mt-3 text-muted">Você ainda não salvou nenhum anúncio.</p>
            <a href="{{ route('animais.index') }}" class="btn btn-primary">Explorar anúncios</a>
        </div>
    @endif
@endsection
