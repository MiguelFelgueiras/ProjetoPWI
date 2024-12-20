<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!empty($_POST)) {
        if (($utilizador = validaUtilizador($_POST['username'], $_POST['password'])) !== false){
            header('Location: home.php');
        } else {
            $message = "Utilizador ou palavra-passe errada";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>

        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center">SuperGestões</h1>
                <p class="lead text-center mt-2">O seu gestor de sócios.</p>
                <p class="text-center">
                    <img src="assets/img/icon.png" alt="" style="height: 50px">
                </p>
            </div>
        </div>

        <?php if (!empty($message)) { ?>
            <div class="row justify-content-center">
                <div class="col-6">
                    <p class="alert alert-danger"><?php echo $message;?></p>
                </div>
            </div>
        <?php } ?>

        <form action="login.php" method="post" class="">
            <div class="row justify-content-center mt-3">
                <label for="" class="col-2 text-end fw-bold">Username</label>
                <div class="col-4">
                    <input type="text" name="username" id="">
                </div>
            </div>
            
            <div class="row justify-content-center mt-3">
                <label for="" class="col-2 text-end fw-bold">Password</label>
                <div class="col-4">
                    <input type="password" name="password" id="">
                </div>
            </div>
            
            <div class="row justify-content-center mt-3">
                <div class="col text-center">
                    <input  class="btn btn-success btn-large" type="submit" value="Iniciar Sessão" name="login_b">
                </div>
            </div>
        </form>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
