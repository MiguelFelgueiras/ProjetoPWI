<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $ret = emitirCobranca($_POST['idSocio'], $_POST['valor'], $_POST['tipo']);
        if ($ret === false) {
            $message = 'Não foi possivel emitir esta cobrança';
            $class = "danger";
        } else {
            $message = "Cobrança emitida com sucesso";
            $class = "success";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Nova Cobrança</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="nova_cobranca.php" method="post" class="">

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Id do Sócio</label>
            <div class="col-4">
                <input type="text" name="idSocio" id="" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Valor</label>
            <div class="col-4">
                <input type="text" name="valor" id="" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="tipo" class="col-2 text-end fw-bold">Tipo</label>
            <div class="col-4">
                <select id="tipo" name="tipo" required>
                    <option value="JOIA">Jóia</option>
                    <option value="QUOTA">Quota</option>
                    <option value="none" selected disabled hidden></option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Emitir Cobrança" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
