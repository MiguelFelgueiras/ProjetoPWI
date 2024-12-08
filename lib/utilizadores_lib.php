<?php

function lerUtilizadores(): array
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $futilizadores = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "r"
    );

    $utilizadores = [];
    while(($linha = fgets($futilizadores)) !== false) {
        $linha = trim($linha);
        $tempUtilizador = explode(";", $linha);

        $utilizadores[] = [
            'idUtilizador' => $tempUtilizador[0],
            'nome' => trim($tempUtilizador[3]),
            'username' => $tempUtilizador[1],
            'password' => $tempUtilizador[2],
            'situacao' => $tempUtilizador[4]
        ];
    }

    fclose($futilizadores);
    return $utilizadores;
}

function obtemProximoIdUser(): int
{
    $utilizadores = lerUtilizadores();

    if (count($utilizadores) == 0) {
        return 1;
    }

    return $utilizadores[count($utilizadores)-1]['idUtilizador'] + 1;
}

function validaUtilizador(string $username, string $password): array|bool
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $utilizadores = lerUtilizadores();
    
    foreach ($utilizadores as $utilizador) {
        if ($username == $utilizador['username']) {
            if (password_verify($password, $utilizador['password'])) {
                @session_start();
                $_SESSION['nome'] = $utilizador['nome'];
                setcookie('socioslogin', json_encode([
                    'utilizador' => $username,
                    'password' => $password,
                ]), time()+ 60);
                return $utilizador;
            } else {
                return false;
            }
        }
    }

    return false;
}

function validaSessao(): bool
{
    @session_start();
    if (empty($_SESSION) || empty($_SESSION['nome'])) {
        if (isset($_COOKIE['socioslogin'])) {
            $dadosCookie = json_decode($_COOKIE['socioslogin'], true);
            $utilizador = validaUtilizador($dadosCookie['utilizador'], $dadosCookie['password']);
            return is_array($utilizador) ? true : $utilizador;
        } else {
            return false;
        }
    }

    return true;
}

function terminaSessao(): bool
{
    if (!validaSessao()) {
        return true;
    }

    setcookie('socioslogin', '', time()-1);

    $_SESSION = [];
    session_destroy();
    return true;
}

function obtemUtilizador(string $username): array|bool
{
    $utilizadores = lerUtilizadores();
    foreach ($utilizadores as $utilizador) {
        if ($utilizador['username'] == $username) {
            return $utilizador;
        }
    }

    return false;
}

function adicionarUtilizador(string $username, string $nome, string $password): array|bool
{
    if (obtemUtilizador($username) !== false) {
        return false;
    }

    $futilizadores = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        'a'
    );

    $idUtilizador=obtemProximoIdUser();
    $resultado = fputs($futilizadores, $idUtilizador . ';' . $username . ';' . password_hash($password, PASSWORD_DEFAULT) . ';' . $nome . ';' . 1 . "\n");
    fclose($futilizadores);
    
    if ($resultado === false) {
        return false;
    }

    return [
        $idUtilizador,
        $username,
        password_hash($password, PASSWORD_DEFAULT),
        $nome,
        1
    ];
}

function modificarUtilizador(string $username, string $nome, string $password, int $situacao): bool
{
    $utilizadores = lerUtilizadores();
    foreach ($utilizadores as $pos => $utilizador) {
        if ($utilizador['username'] == $username) {
            $utilizadores[$pos]['nome'] = $nome;
            if ($password != '') {
                $utilizadores[$pos]['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $utilizadores[$pos]['situacao'] = $situacao;
            escreverUtilizadores($utilizadores);
            return true;
        }
    }

    return false;
}

function escreverUtilizadores(array $utilizadores): bool
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $futilizadores = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "w"
    );

    foreach($utilizadores as $utilizador) {
        fputs(
            $futilizadores,
            $utilizador['idUtilizador'] . ';'
            . $utilizador['username'] . ';'
            . $utilizador['password'] . ';'
            . $utilizador['nome'] . ';'
            . $utilizador['situacao'] . "\n"
        );
    }

    fclose($futilizadores);
    return true;
}
