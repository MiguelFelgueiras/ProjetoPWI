<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">SuperGestões</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="home.php">Ínicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="utilizadores.php">Utilizadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="socios.php">Sócios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cobrancas.php">Cobranças</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Terminar Sessão</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Função para confirmar o logout (caso você ainda precise dessa funcionalidade em algum lugar)
    function confirmSaida() {
        if (confirm('Tem a certeza que deseja terminar sessão?')) {
            window.location.href = 'logout.php';
        }
    }
</script>
