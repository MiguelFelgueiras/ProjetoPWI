<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container pt-5">
    <?php
        $socio = obtemSocios($_GET['idSocio']);
        if ($socio === false) { ?>
            <div class="row">
                <div class="col">
                    <p class="alert alert-danger">Sócio não encontrado!!!</p>
                </div>
            </div>
        <?php } else { ?>
            <div class="card">
                <h5 class="card-header">Dados do Sócio</h5>
                <div class="card-body">
                    <h5 class="card-title">Nome: <?php echo $socio['nome'];?></h5>
                    <h5 class="card-title">NIF: <?php echo $socio['nif'];?></h5>
                    <h5 class="card-title">Data de Nascimento: <?php echo $socio['nascimento'];?></h5>
                    <h5 class="card-title">Morada: <?php echo $socio['morada'].', '. $socio['localidade'];?></h5>
                    <h5 class="card-title">Código Postal: <?php echo $socio['codPostal'];?></h5>
                    <h5 class="card-title">Email: <?php echo $socio['email'];?></h5>
                    <h5 class="card-title">Sexo: <?php echo $socio['sexo'];?></h5>
                    <h5 class="card-title">Situação: <?php echo $socio['situacao'];?></h5>
                    <p class="text-center">
                    <a href="modificar_socio.php?idSocio=<?php echo $socio['idSocio'];?>" class="btn btn-primary">Modificar</a>
                    </p>
                </div>
            </div>
    <?php } ?>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>