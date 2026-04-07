<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PatasDigitais</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
@vite('resources/css/app.css')
@vite('resources/js/app.js')
</head>
<body> 
    <header class="topbar">

    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuLateral">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <!-- PERFIL -->
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-person-circle fs-2 me-2"></i>
            <div>
                <strong>{{ Auth::user()->name ?? 'Usuário' }}</strong><br>
                <a href="/perfil">Ver perfil</a>
            </div>
        </div>

        <hr>

        <!-- LINKS -->
        <ul class="list-unstyled">

            <li class="mb-3">
                <a href="/anuncios" class="text-decoration-none">
                    <i class="bi bi-megaphone me-2"></i>
                    Seus anúncios
                </a>
            </li>

            <li class="mb-3">
                <a href="/salvos" class="text-decoration-none">
                    <i class="bi bi-bookmark me-2"></i>
                    Anúncios salvos
                </a>
            </li>

            <li class="mb-3">
                <a href="/conversas" class="text-decoration-none">
                    <i class="bi bi-chat-dots me-2"></i>
                    Conversas
                </a>
            </li>

        </ul>

    </div>
</div>
    
    <div class="topbar-accent"></div>

    <div class="topbar-content">
        <div class="logo">
            <img src="{{ asset('storage/logo.png') }}" alt="Patas Digitais">
        </div>

        <div class="menu-icon">
    <i class="bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"></i>
</div>
    </div>
</header>
<div class="container py-3">

    @yield('conteudo')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>