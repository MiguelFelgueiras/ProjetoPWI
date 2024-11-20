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
        $tempUtilizador = explode(";", $linha);

        $utilizadores[] = [
            'nome' => trim($tempUtilizador[2]),
            'username' => $tempUtilizador[0],
            'password' => $tempUtilizador[1],
        ];
    }

    fclose($futilizadores);
    return $utilizadores;
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
                setcookie('tarefaslogin', json_encode([
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
        if (isset($_COOKIE['tarefaslogin'])) {
            $dadosCookie = json_decode($_COOKIE['tarefaslogin'], true);
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

    setcookie('tarefaslogin', '', time()-1);

    $_SESSION = [];
    session_destroy();
    return true;
}
