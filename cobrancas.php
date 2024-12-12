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

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Cobranças</h1>
        </div>
    </div>

    <form action="cobrancas.php" method="post" class="mt-3 mb-3">
        <div class="row">
            <div class="col-8">
                <input type="text" name="pesquisa" id="" class="form-control" placeholder="Filtrar Resultados">
            </div>
            <div class="col-2">
                <input type="submit" value="Filtrar" name="search_b" class="btn btn-secondary col-12">
            </div>
        </div>
        
    </form>
    <hr>

    <div class="row">
        <div class="col text-end">
            <a href="nova_cobranca.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>Emitir Cobrança
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id da Cobrança</th>
                        <th>Data de Emissão</th>
                        <th>Id do Sócio</th>
                        <th>Valor</th>
                        <th>Situação</th>
                        <th>Tipo</th>
                        <th>Data de Pagamento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $cobrancas = lerCobrancas($_POST['pesquisa'] ?? '');
                        foreach ($cobrancas as $cobranca) { ?>
                            <tr>
                                <td><?php echo $cobranca['idCobranca'];?></td>
                                <td><?php echo $cobranca['dataEmissao'];?></td>
                                <td><?php echo $cobranca['idSocio'];?></td>
                                <td><?php echo $cobranca['valor'];?></td>
                                <td><?php echo $cobranca['situacao'];?></td>
                                <td><?php echo $cobranca['tipo'];?></td>
                                <td><?php echo $cobranca['dataPagamento'];?></td>
                                <td class="text-end">
                                    <a href="ver_cobranca.php?idCobranca=<?php echo $cobranca['idCobranca'];?>" class="btn btn-secondary">
                                        <i class="fa-solid fa-info fa-fw"></i>
                                    </a>
                                    <a href="modificar_cobranca.php?idCobranca=<?php echo $cobranca['idCobranca'];?>" class="btn btn-warning">
                                        <i class="fa-solid fa-user-pen fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
