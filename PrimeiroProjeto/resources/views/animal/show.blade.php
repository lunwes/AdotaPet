@extends('layout')

@section('conteudo')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalhes do Animal</h2>
        <div>
            <a href="{{ route('animais.edit', $animal->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('animais.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div class="animal-detail-card">
        <div class="detail-content-grid">
            <!-- Área de fotos -->
            <div class="foto-detail-area">
                <div class="foto-principal">
                    @php
                        $fotoPrincipal = $animal->fotos->first();
                    @endphp
                    @if($fotoPrincipal)
                        <img src="{{ asset('storage/' . $fotoPrincipal->caminho) }}" 
                             alt="Foto de {{ $animal->nome }}"
                             id="fotoPrincipal"
                             style="width: 100%; height: 300px; object-fit: cover; border-radius: 10px;">
                    @else
                        <div class="sem-foto" style="width: 100%; height: 300px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <span>Sem foto</span>
                        </div>
                    @endif
                </div>
                
                @if($animal->fotos->count() > 1)
                    <div class="foto-miniaturas" style="display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap;">
                        @foreach($animal->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->caminho) }}" 
                                 alt="Foto de {{ $animal->nome }}"
                                 class="foto-miniatura"
                                 onclick="document.getElementById('fotoPrincipal').src = this.src"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent;">
                        @endforeach
                    </div>
                @endif
                <small class="text-muted">* Clique nas miniaturas para trocar a foto principal</small>
            </div>

            <div class="info-detail-area">
                <div class="info-group">
                    <label>Nome:</label>
                    <p class="info-value">{{ $animal->nome }}</p>
                </div>

                <div class="info-group">
                    <label>Sobre:</label>
                    <p class="info-value">{{ $animal->sobre ?: 'Não informado' }}</p>
                </div>

                <div class="linha-detail">
                    <div class="info-group">
                        <label>Data de Nascimento:</label>
                        <p class="info-value">{{ $animal->data_nascimento ? \Carbon\Carbon::parse($animal->data_nascimento)->format('d/m/Y') : 'Não informada' }}</p>
                    </div>

                    <div class="info-group">
                        <label>Idade:</label>
                        <p class="info-value">{{ $animal->data_nascimento ? \Carbon\Carbon::parse($animal->data_nascimento)->age . ' anos' : 'Desconhecida' }}</p>
                    </div>
                </div>

                <div class="linha-detail">
                    <div class="info-group">
                        <label>Sexo:</label>
                        <p class="info-value">{{ $animal->sexo == 'macho' ? 'Macho' : 'Fêmea' }}</p>
                    </div>

                    <div class="info-group">
                        <label>Castrado:</label>
                        <p class="info-value">{{ $animal->castracao ? 'Sim' : 'Não' }}</p>
                    </div>

                    <div class="info-group">
                        <label>Espécie:</label>
                        <p class="info-value">{{ $animal->especie->nome ?? 'Não informada' }}</p>
                    </div>
                </div>

                <!-- Vacinas -->
                <div class="info-group">
                    <label>Vacinas:</label>
                    <div class="vacinas-tags-detail">
                        @if($animal->vacinas->count() > 0)
                            @foreach($animal->vacinas as $vacina)
                                <span class="tag-vacina-detail">{{ $vacina->nome }}</span>
                            @endforeach
                        @else
                            <p class="info-value">Nenhuma vacina registrada</p>
                        @endif
                    </div>
                </div>

                <div class="status-group">
                    <label>Status de Adoção:</label>
                    <p class="status-badge {{ $animal->adotado ? 'status-adotado' : 'status-disponivel' }}">
                        {{ $animal->adotado ? 'Adotado' : 'Disponível para adoção' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection