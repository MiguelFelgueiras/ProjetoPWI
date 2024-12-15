<?php

include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

/**
 * Lê um ficheiro com dados de cobranças, aplica filtros opcionais de pesquisa e retorna um array com os dados.
 *
 * @param string $pesquisa
 * @return array
 */
function lerCobrancas(string $pesquisa = ''): array
{
    // abrir o ficheiro no directorio superior data/cobrancas no modo de leitura
    $fcobrancas = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "cobrancas.txt",
        "r"
    );

    $cobrancas = [];
    while(($linha = fgets($fcobrancas)) !== false) {
        $linha = trim($linha);
        $tempCobranca = explode(";", $linha);

        if (count($tempCobranca) < 7){
            continue;
        }

        if (!empty($pesquisa) && (stripos($tempCobranca[1], $pesquisa) === false) && (stripos($tempCobranca[2], $pesquisa) === false) && (stripos($tempCobranca[4], $pesquisa) === false)) {
            continue;
        }

        $cobrancas[] = [
            'idCobranca' => $tempCobranca[0],
            'dataEmissao' => $tempCobranca[1],
            'idSocio' => $tempCobranca[2],
            'valor' => $tempCobranca[3],
            'situacao' => $tempCobranca[4],
            'tipo' => $tempCobranca[5],
            'dataPagamento' => $tempCobranca[6],
        ];
    }

    fclose($fcobrancas);
    return $cobrancas;
}

/**
 * Obtém uma cobrança específica pelo ID
 *
 * @param string $idCobranca
 * @return array|boolean
 */
function obtemCobranca(string $idCobranca): array|bool
{
    $cobrancas = lerCobrancas();
    foreach ($cobrancas as $cobranca) {
        if ($cobranca['idCobranca'] == $idCobranca) {
            return $cobranca;
        }
    }

    return false;
}

/**
 * Atualiza os dados de uma cobrança específica no ficheiro
 *
 * @param string $idCobranca
 * @param string $valor
 * @param string $situacao
 * @param string $tipo
 * @return boolean
 */
function modificarCobranca(string $idCobranca, string $valor, string $situacao, string $tipo): bool
{
    $cobrancas = lerCobrancas();
    foreach ($cobrancas as $pos => $cobranca) {
        if ($cobranca['idCobranca'] == $idCobranca) {
            $cobrancas[$pos]['valor'] = $valor;
            $cobrancas[$pos]['situacao'] = $situacao;
            $cobrancas[$pos]['tipo'] = $tipo;
            escreverCobranca($cobrancas);
            return true;
        }
    }
    return false;
}

/**
 * Sobrescreve o ficheiro de cobranças com um novo conjunto de dados
 *
 * @param array $cobrancas
 * @return boolean
 */
function escreverCobranca(array $cobrancas): bool
{
    // abrir o ficheiro no directorio superior data/cobrancas, no modo de escrita
    $fcobrancas = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "cobrancas.txt",
        "w"
    );

    foreach($cobrancas as $cobranca) {
        fputs(
            $fcobrancas,
            $cobranca['idCobranca'] . ';'
            . $cobranca['dataEmissao'] . ';'
            . $cobranca['idSocio'] . ';'
            . $cobranca['valor'] . ';'
            . $cobranca['situacao'] . ';'
            . $cobranca['tipo'] . ';'
            . $cobranca['dataPagamento'] . "\n"
        );
    }

    fclose($fcobrancas);
    return true;
}

/**
 * Calcula o próximo ID da cobrancça com base no último ID presente no array de cobranças
 *
 * @return integer
 */
function obtemProximoIdCobranca(): int
{
    $cobrancas = lerCobrancas();

    if (count($cobrancas) == 0) {
        return 1;
    }

    return $cobrancas[count($cobrancas)-1]['idCobranca'] + 1;
}

/**
 * Cria e grava uma nova cobrança no ficheiro, associando-a a um sócio
 *
 * @param string $idSocio
 * @param string $valor
 * @param string $tipo
 * @return array|boolean
 */
function emitirCobranca(string $idSocio, string $valor, string $tipo): array|bool
{
    $idCobranca = obtemProximoIdCobranca();
    
    $fcobrancas = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "cobrancas.txt",
        'a'
    );

    $cobranca = [
        $idCobranca,
        date('Y-m-d H:i:s'),
        $idSocio,
        $valor,
        'PENDENTE',
        $tipo,
        ''
    ];

    $resultado = fputs($fcobrancas, implode(';', $cobranca) . "\n");
    fclose($fcobrancas);
    
    if ($resultado === false) {
        return false;
    }

    return $cobranca;

}
