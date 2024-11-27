<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $ret = adicionarSocio($_POST['name'], $_POST['nif'], $_POST['nascimento'], $_POST['morada'], $_POST['codPostal'], $_POST['localidade'], $_POST['email'], $_POST['sexo'], $_POST['situacao']);
        if ($ret === false) {
            $message = 'Não foi possivel adicionar este sócio';
            $class = "danger";
        } else {
            $message = "Sócio adicionado com sucesso";
            $class = "success";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Novo Sócio</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="novo_socio.php" method="post" class="">

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input type="text" name="name" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">NIF</label>
            <div class="col-4">
                <input type="text" name="nif" maxlength="11" placeholder="### ### ###" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Data de Nascimento</label>
            <div class="col-4">
                <input type="date" name="nascimento" id="">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Morada</label>
            <div class="col-4">
                <input type="text" name="morada" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Código Postal</label>
            <div class="col-4">
                <input type="text" maxlength="8" placeholder="####-###" name="codPostal" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Localidade</label>
            <div class="col-4">
                <input type="text" name="localidade" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Email</label>
            <div class="col-4">
                <input type="email" name="email" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="sexo" class="col-2 text-end fw-bold">Sexo</label>
            <div class="col-4">
                <select id="sexo" name="sexo">
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="situacao" class="col-2 text-end fw-bold">Situação</label>
            <div class="col-4">
                <select id="situacao" name="situacao">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Registar Utilizador" name="form_b">
            </div>
        </div>
    </form>
</div>
