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


<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Sócios</h1>
        </div>
    </div>

    <form action="socios.php" method="post" class="mt-3 mb-3">
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
            <a href="novo_socio.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>Registar Sócio
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nº de Sócio</th>
                        <th>Nome</th>
                        <th>NIF</th>
                        <th>Data de Nascimento</th>
                        <th>Morada</th>
                        <th>Cod Postal</th>
                        <th>Localidade</th>
                        <th>Email</th>
                        <th>Sexo</th>
                        <th>Tipo</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $socios = lerSocios($_POST['pesquisa'] ?? '');
                        foreach ($socios as $socio) { ?>
                            <tr>
                                <td><?php echo $socio['idSocio'];?></td>
                                <td><?php echo $socio['nome'];?></td>
                                <td><?php echo $socio['nif'];?></td>
                                <td><?php echo $socio['nascimento'];?></td>
                                <td><?php echo $socio['morada'];?></td>
                                <td><?php echo $socio['codPostal'];?></td>
                                <td><?php echo $socio['localidade'];?></td>
                                <td><?php echo $socio['email'];?></td>
                                <td><?php echo $socio['sexo'];?></td>
                                <td><?php echo $socio['situacao'];?></td>
                                <td class="text-end">
                                    <a href="ver_socio.php?idSocio=<?php echo $socio['idSocio'];?>" class="btn btn-secondary">
                                        <i class="fa-solid fa-info fa-fw"></i>
                                    </a>
                                    <a href="modificar_socio.php?idSocio=<?php echo $socio['idSocio'];?>" class="btn btn-warning">
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
