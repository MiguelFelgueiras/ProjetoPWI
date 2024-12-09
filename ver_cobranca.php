<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container pt-5">
    <?php
        $cobranca = obtemCobrancas($_GET['idCobranca']);
        if ($cobranca === false) { ?>
            <div class="row">
                <div class="col">
                    <p class="alert alert-danger">Cobrança não encontrada!!!</p>
                </div>
            </div>
        <?php } else { ?>
            <div class="card">
                <h5 class="card-header">Dados da Cobrança</h5>
                <div class="card-body">
                    <h5 class="card-title">Data de Emissão: <?php echo $cobranca['dataEmissao'];?></h5>
                    <h5 class="card-title">idSocio: <?php echo $cobranca['idSocio'];?></h5>
                    <h5 class="card-title">Valor: <?php echo $cobranca['valor'];?></h5>
                    <h5 class="card-title">Situação: <?php echo $cobranca['situacao'];?></h5>
                    <h5 class="card-title">Tipo: <?php echo $cobranca['tipo'];?></h5>
                    <h5 class="card-title">Data de Pagamento: <?php echo $cobranca['dataPagamento'];?></h5>
                    <p class="text-center">
                    <a href="modificar_cobranca.php?idCobranca=<?php echo $cobranca['idCobranca'];?>" class="btn btn-primary">Modificar</a>
                    </p>
                </div>
            </div>
    <?php } ?>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
