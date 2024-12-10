<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';


    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $cobranca = obtemCobranca($_GET['idCobranca']);
        $ret = modificarCobranca($_GET['idCobranca'], $_POST['valor'], $_POST['situacao'],$_POST['tipo']);
        if ($ret === false) {
            $message = 'Não foi possivel modificar a cobrança';
            $class = "danger";
        } else {
            $message = "Cobrança modificada com sucesso";
            $class = "success";
            $utilizador = obtemCobranca($_GET['idCobranca']);
        }
    } else {
        $utilizador = obtemCobranca($_GET['idCobranca']);
        if ($utilizador === false) {
            $message = 'Não existe a Cobrança';
            $class = "danger";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Modificar Cobrança</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="modificar_cobranca.php?idCobranca=<?php echo $_GET['idCobranca'];?>" method="post" class="" autocomplete="off">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Valor</label>
            <div class="col-4">
                <input type="text" name="valor" id="" autocomplete="name" value="<?php echo $utilizador['valor'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="situacao" class="col-2 text-end fw-bold">Situação</label>
            <div class="col-4">
                <select id="situacao" name="situacao">
                    <option value="PAGO">Pago</option>
                    <option value="PENDENTE">Pendente</option>
                    <option value="CANCELADO">Cancelado</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="tipo" class="col-2 text-end fw-bold">Tipo</label>
            <div class="col-4">
                <select id="tipo" name="tipo">
                    <option value="JOIA">Jóia</option>
                    <option value="QUOTA">Quota</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Modificar Cobranca" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
