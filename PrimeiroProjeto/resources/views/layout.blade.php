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
    <div class="topbar-accent"></div>

    <div class="topbar-content">
        <div class="logo">
            <img src="{{ asset('storage/logo.png') }}" alt="Patas Digitais">
        </div>

        <div class="menu-icon">
            <i class="bi bi-list"></i>
        </div>
    </div>
</header>
<div class="container py-3">

    @yield('conteudo')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</div>
</body>
</html>