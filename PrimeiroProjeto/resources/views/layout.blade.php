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

<<<<<<< HEAD
    <div class="offcanvas offcanvas-end" tabindex="-1" id="menuLateral">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column">
            <!-- PERFIL (aparece só se logado) -->
            @auth
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-person-circle fs-2 me-2"></i>
                    <div>
                        <strong>{{ Auth::user()->name }}</strong>
                        <br>
                        <a href="/perfil" class="small">Ver perfil</a>
                    </div>
                </div>
                <hr>
            @endauth

            <!-- LINKS -->
            <ul class="list-unstyled flex-grow-1">
                <li class="mb-3">
                    <a href="{{ route('animais.index') }}" class="text-decoration-none">
                        <i class="bi bi-house me-2"></i>
                        Início
                    </a>
                </li>
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

            <!-- BOTÃO LOGOUT (só aparece se logado, no final do menu) -->
            @auth
                <hr>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Sair
                    </button>
                </form>
            @endauth

            <!-- BOTÃO LOGIN (se não estiver logado) -->
            @guest
                <hr>
                <a href="{{ route('login') }}" class="btn btn-custom w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Entrar
                </a>
            @endguest
        </div>
    </div>
=======
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
>>>>>>> 66f3e70f1b1a602a980964625d01b8f10e13612e
    
    <div class="topbar-accent"></div>

    <div class="topbar-content">
        <div class="logo">
            <img src="{{ asset('storage/logo.png') }}" alt="Patas Digitais">
        </div>

        <div class="menu-icon">
<<<<<<< HEAD
            <i class="bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"></i>
        </div>
=======
    <i class="bi bi-list" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"></i>
</div>
>>>>>>> 66f3e70f1b1a602a980964625d01b8f10e13612e
    </div>
    </header>

    <div class="container py-3">
        @yield('conteudo')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>