<?php
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
    $socios = lerSocios();
    foreach ($socios as $socio) {
        if ($socio['idSocio'] == $idSocio) {
            return $socio;
        }
    }

    return false;
}

function obtemProximoIdSocio(): int
{
    $socios = lerSocios();

    if (count($socios) == 0) {
        return 1;
    }

    return $socios[count($socios)-1]['idSocio'] + 1;
}

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
    
    if ($resultado === false) {
        return false;
    }

    return $socio;

}
