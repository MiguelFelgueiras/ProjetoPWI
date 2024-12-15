<?php

/**
 *Lê os utilizadores de um ficheiro de texto, organiza os dados em um array associativo e retorna o array
 *
 * @return array
 */
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

/**
 *Calcula o próximo ID do utilizador com base no último ID presente no array de utilizadores
 *
 * @return integer
 */
function obtemProximoIdUser(): int
{
    $utilizadores = lerUtilizadores();

    if (count($utilizadores) == 0) {
        return 1;
    }

    return $utilizadores[count($utilizadores)-1]['idUtilizador'] + 1;
}

/**
 * Valida o utilizador e a palavra-passe, iniciando a sessão e configurando um cookie em caso de sucesso
 *
 * @param string $username
 * @param string $password
 * @return array|boolean
 */
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

/**
 * Valida se a sessão está ativa ou tenta restaurá-la usando informações de cookies
 *
 * @return boolean
 */
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

/**
 * Termina a sessão e remove o cookie associado
 *
 * @return boolean
 */
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

/**
 * Obtém os dados de um utilizador específico pelo nome de utilizador
 *
 * @param string $username
 * @return array|boolean
 */
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

/**
 * Adiciona um novo utilizador ao ficheiro de utilizadores
 *
 * @param string $username
 * @param string $nome
 * @param string $password
 * @return array|boolean
 */
function adicionarUtilizador(string $username, string $nome, string $password): array|bool
{
    // Validar que o username contém apenas letras
    if (!preg_match('/^[a-zA-Z]+$/', $username)) {
        return false; // Username inválido
    }

    // Verificar se o username já existe
    if (obtemUtilizador($username) !== false) {
        return false; // Username já em uso
    }

    // Validar palavra-passe
    if (!verificarPassword($password)) {
        return false; // Palavra-passe inválida
    }

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

/**
 * Modifica os dados de um utilizador específico, incluindo palavra-passe e situação
 *
 * @param string $username
 * @param string $nome
 * @param string $password
 * @param integer $situacao
 * @return boolean
 */
function modificarUtilizador(string $username, string $nome, string $password, int $situacao): bool
{
    $utilizadores = lerUtilizadores();
    foreach ($utilizadores as $pos => $utilizador) {
        if ($utilizador['username'] == $username) {
            $utilizadores[$pos]['nome'] = $nome;
            if ($password != '') {
                 // Validar palavra-passe antes de alterar
                if (!verificarPassword($password)) {
                    return false; // Palavra-passe inválida
                }
                $utilizadores[$pos]['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $utilizadores[$pos]['situacao'] = $situacao;
            escreverUtilizadores($utilizadores);
            return true;
        }
    }

    return false;
}

/**
 * Escreve por cima dos dados anteriormente no ficheiro de utilizadores com os dados fornecidos
 *
 * @param array $utilizadores
 * @return boolean
 */
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

/**
 * Valida os critérios de criar e alterar uma palavra-passe
 *
 * @param string $password
 * @return boolean
 */
function verificarPassword(string $password): bool
{
    // Verifica se a palavra-passe tem pelo menos 8 caracteres, 
    $temTamanhoMinimo = strlen($password) >= 8;
    // uma letra maiúscula,
    $temMaiuscula = preg_match('/[A-Z]/', $password);
    // uma letra minúscula
    $temMinuscula = preg_match('/[a-z]/', $password);
    // e um número
    $temNumero = preg_match('/[0-9]/', $password);

    return $temTamanhoMinimo && $temMaiuscula && $temMinuscula && $temNumero;
}
