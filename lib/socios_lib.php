<?php

include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';

/**
 * Lê um ficheiro de sócios, filtra os dados com base em uma pesquisa opcional e retorna um array com os dados
 *
 * @param string $pesquisa
 * @return array
 */
function lerSocios(string $pesquisa = ''): array
{
    if (!file_exists( "data" . DIRECTORY_SEPARATOR . "socios.txt")) {
        return [];
    }
    // abrir o ficheiro no directorio superior data/socios
    $fsocios = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        "r"
    );

    $socios = [];
    while(($linha = fgets($fsocios)) !== false) {
        $linha = trim($linha);
        $tempSocio = explode(";", $linha);

        if (count($tempSocio) !== 10) {
            continue; // Ignorar linhas malformadas
        }

        // Verifica o filtro de pesquisa em todos os campos
        if (!empty($pesquisa)) {
            // Concatenar todos os campos e verificar a presença da pesquisa
            $todosCampos = implode(' ', array_map('trim', $tempSocio));
            if (stripos($todosCampos, $pesquisa) === false) {
                continue; // Ignorar sócios que não correspondem à pesquisa
        }
        }

        $socios[] = [
            'idSocio' => trim($tempSocio[0]),
            'nome' => trim($tempSocio[1]),
            'nif' => trim($tempSocio[2]),
            'nascimento' => trim($tempSocio[3]),
            'morada' => trim($tempSocio[4]),
            'codPostal' => trim($tempSocio[5]),
            'localidade' => trim($tempSocio[6]),
            'email' => trim($tempSocio[7]),
            'sexo' => trim($tempSocio[8]),
            'situacao' => trim($tempSocio[9]),
        ];
    }

    fclose($fsocios);
    return $socios;
}

/**
 * Calcula o próximo ID do sócio com base no último ID presente no ficheiro
 *
 * @return integer
 */
function obtemProximoIdSocio(): int
{
    $socios = lerSocios();

    if (count($socios) == 0) {
        return 1;
    }

    return $socios[count($socios)-1]['idSocio'] + 1;
}

/**
 * Retorna os dados de um sócio específico pelo ID
 *
 * @param string $idSocio
 * @return array|boolean
 */
function obtemSocios(string $idSocio): array|bool
{
    $socios = lerSocios();
    foreach ($socios as $socio) {
        if ($socio['idSocio'] == $idSocio) {
            return $socio;
        }
    }

    return false;
}

/**
 * Adiciona um novo sócio ao ficheiro e emite uma cobrança associada do tipo Jóia
 *
 * @param string $nome
 * @param string $nif
 * @param string $nascimento
 * @param string $morada
 * @param string $codPostal
 * @param string $localidade
 * @param string $email
 * @param string $sexo
 * @param string $situacao
 * @return array|boolean
 */
function adicionarSocio(string $nome, string $nif, string $nascimento, string $morada, string $codPostal,string $localidade,string $email,string $sexo,string $situacao): array|bool
{
    $idSocio = obtemProximoIdSocio();
    
    $fsocios = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        'a'
    );

    $socio = [
        $idSocio,
        $nome,
        $nif,
        $nascimento,
        $morada,
        $codPostal,
        $localidade,
        $email,
        $sexo,
        $situacao
    ];

    $resultado = fputs($fsocios, implode(';', $socio) . "\n");
    fclose($fsocios);
    
    emitirCobranca($idSocio, '80,0','JOIA');
    if ($resultado === false) {
        return false;
    }

    return $socio;

}

/**
 * Modifica os dados de um sócio existente no ficheiro
 *
 * @param string $idSocio
 * @param string $nome
 * @param string $nascimento
 * @param string $morada
 * @param string $codPostal
 * @param string $localidade
 * @param string $email
 * @param string $sexo
 * @param string $situacao
 * @return array|boolean
 */
function modificarSocio(string $idSocio, string $nome, string $nascimento, string $morada, string $codPostal,string $localidade,string $email,string $sexo,string $situacao): array|bool
{
    $socios = lerSocios();
    foreach ($socios as $pos => $socio) {
        if ($socio['idSocio'] == $idSocio) {
            $socios[$pos]['nome'] = $nome;
            $socios[$pos]['nascimento'] = $nascimento;
            $socios[$pos]['morada'] = $morada;
            $socios[$pos]['codPostal'] = $codPostal;
            $socios[$pos]['localidade'] = $localidade;
            $socios[$pos]['email'] = $email;
            $socios[$pos]['sexo'] = $sexo;
            $socios[$pos]['situacao'] = $situacao;
            escreverSocios($socios);
            return true;
        }
    }

    return false;
}

/**
 * Escreve por cima dos dados anteriormente no ficheiro de sócios com os dados fornecidos
 *
 * @param array $socios
 * @return boolean
 */
function escreverSocios(array $socios): bool
{
    // abrir o ficheiro no directorio superior data/socios
    $fsocios = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        "w"
    );

    foreach($socios as $socio) {
        
        $linha = $socio['idSocio'] . ';'
        . $socio['nome'] . ';'
        . $socio['nif'] . ';'
        . $socio['nascimento'] . ';'
        . $socio['morada'] . ';'
        . $socio['codPostal'] . ';'
        . $socio['localidade'] . ';'
        . $socio['email'] . ';'
        . $socio['sexo'] . ';'
        . $socio['situacao'] . "\n";

        fputs($fsocios,$linha);
    }

    fclose($fsocios);
    return true;
}
