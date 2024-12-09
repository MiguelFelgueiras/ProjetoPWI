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
