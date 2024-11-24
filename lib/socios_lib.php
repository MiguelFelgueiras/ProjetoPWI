<?php

include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

function lerSocios(): array
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $fsocios = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        "r"
    );

    $socios = [];
    while(($linha = fgets($fsocios)) !== false) {
        $tempSocio = explode(";", $linha);

        $socios[] = [
            'idSocio' => $tempSocio[0],
            'nome' => trim($tempSocio[1]),
            'nif' => $tempSocio[2],
            'nascimento' => $tempSocio[3],
            'morada' => $tempSocio[4],
            'codPostal' => $tempSocio[5],
            'localidade' => $tempSocio[6],
            'email' => $tempSocio[7],
            'sexo' => $tempSocio[8],
            'situacao' => $tempSocio[9],
        ];
    }

    fclose($fsocios);
    return $socios;
}

function obtemSocios(string $idSocio): array|bool
{
    $socios = lerUtilizadores();
    foreach ($socios as $socio) {
        if ($socios['idSocio'] == $idSocio) {
            return $socio;
        }
    }

    return false;
}
