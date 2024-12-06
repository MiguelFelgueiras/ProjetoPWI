<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/menu.php'; ?>

<div class="container my-5">
    <div class="row text-center">
        <div class="col">
            <h1 class="display-4 text-primary">Bem-vindo ao SuperGestões</h1>
            <p class="lead text-muted">Gestão eficiente para o seu negócio. Acompanhe e administre tudo num só lugar.</p>
        </div>
    </div>
</div>

<div class="container content">
    <div class="row text-center mb-5">
        <div class="col">
            <h2>O que deseja fazer?</h2>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Utilizadores</h5>
                    <p class="card-text">Gerir os utilizadores do sistema.</p>
                    <a href="utilizadores.php" class="btn btn-primary">Ver Utilizadores</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Sócios</h5>
                    <p class="card-text">Consultar e gerir informações dos sócios.</p>
                    <a href="socios.php" class="btn btn-primary">Ver Sócios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Cobranças</h5>
                    <p class="card-text">Acompanhar o status das cobranças.</p>
                    <a href="cobrancas.php" class="btn btn-primary">Ver Cobranças</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>
