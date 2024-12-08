<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $socio = obtemSocios($_GET['idSocio']);
        $ret = modificarSocio($_GET['idSocio'], $_POST['nome'], $_POST['nascimento'], $_POST['morada'], $_POST['codPostal'], $_POST['localidade'],$_POST['email'],$_POST['sexo'],$_POST['situacao']);
        if ($ret === false) {
            $message = 'Não foi possivel modificar o sócio';
            $class = "danger";
        } else {
            $message = "Sócio modificado com sucesso";
            $class = "success";
            $socio = obtemSocios($_GET['idSocio']);
        }
    } else {
        $socio = obtemsocios($_GET['idSocio']);
        if ($socio === false) {
            $message = 'Não existe o Sócio';
            $class = "danger";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Modificar Sócio</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="modificar_socio.php?idSocio=<?php echo $_GET['idSocio'];?>" method="post" class="" autocomplete="off">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Id Sócio</label>
            <div class="col-4">
                <input type="text" name="idSocio" id="" autocomplete="name" value="<?php echo $socio['idSocio'];?>" readonly>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input type="text" name="nome" id="" autocomplete="name" value="<?php echo $socio['nome'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nif</label>
            <div class="col-4">
                <input type="text" name="nif" id="" autocomplete="name" value="<?php echo $socio['nif'];?>" readonly>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Data de Nascimento</label>
            <div class="col-4">
                <input type="text" name="nascimento" id="" autocomplete="name" value="<?php echo $socio['nascimento'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Morada</label>
            <div class="col-4">
                <input type="text" name="morada" id="" autocomplete="name" value="<?php echo $socio['morada'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Código Postal</label>
            <div class="col-4">
                <input type="text" name="codPostal" id="" autocomplete="name" value="<?php echo $socio['codPostal'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Localidade</label>
            <div class="col-4">
                <input type="text" name="localidade" id="" autocomplete="name" value="<?php echo $socio['localidade'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Email</label>
            <div class="col-4">
                <input type="email" name="email" id="" autocomplete="email" value="<?php echo $socio['email'];?>">
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Sexo</label>
            <div class="col-4">
                <input type="text" name="sexo" id="" autocomplete="name" value="<?php echo $socio['sexo'];?>">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="situacao" class="col-2 text-end fw-bold">Situação</label>
            <div class="col-4">
                <select id="situacao" name="situacao">
                    <option value="Ativo">Ativo</option>
                    <option value="Suspenso">Suspenso</option>
                    <option value="Pendente">Pendente</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Modificar Sócio" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
