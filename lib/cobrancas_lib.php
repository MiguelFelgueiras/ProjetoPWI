<?php

function lerCobrancas(): array
{
    // abrir o ficheiro no directorio superior data/utilizadores
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

function obtemProximoIdCobranca(): int
{
    $cobrancas = lerCobrancas();

    if (count($cobrancas) == 0) {
        return 1;
    }

    return $cobrancas[count($cobrancas)-1]['idCobranca'] + 1;
}

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
