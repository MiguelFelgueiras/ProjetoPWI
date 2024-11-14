<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/menu.php'; ?>


<body style="text-align: center">
    <h1>Registo de Sócios</h1>
    <form action="processar_socio.php" method="post">
        <label for="nome">Nome do Sócio:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="nif">NIF:</label><br>
        <input type="text" id="nif" name="nif" pattern="[0-9]{9}" required><br><br>

        <label for="data_nascimento">Data de Nascimento:</label><br>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br><br>

        <label for="morada">Morada:</label><br>
        <input type="text" id="morada" name="morada" required><br><br>

        <label for="codigo_postal">Código Postal:</label><br>
        <input type="text" id="codigo_postal" name="codigo_postal" pattern="[0-9]{4}-[0-9]{3}" required><br><br>

        <label for="localidade">Localidade:</label><br>
        <input type="text" id="localidade" name="localidade" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="sexo">Sexo:</label><br>
        <select id="sexo" name="sexo" required>
            <option value="MASCULINO">Masculino</option>
            <option value="FEMININO">Feminino</option>
        </select><br><br>

        <input type="submit" value="Registar Sócio"
        style="align-items: center;
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: .25rem;
            box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
            box-sizing: border-box;
            border-color: black;
            cursor: pointer;
            display: inline-flex;
            font-size: 16px;
            font-weight: 600;
            justify-content: center;
            line-height: 1.25;
            margin: 0;
            min-height: 3rem;
            padding: calc(.875rem - 1px) calc(1.5rem - 1px);
            position: relative;
            text-decoration: none;
            transition: all 250ms;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            width: auto;">
        


<!--
.button-6 {

  color: rgba(0, 0, 0, 0.85);
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 16px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}!-->

<?php include_once 'partials/footer.php'; ?>
