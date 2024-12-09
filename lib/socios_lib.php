<?php
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

        // Verificar o filtro de pesquisa em todos os campos
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

function obtemProximoIdSocio(): int
{
    $socios = lerSocios();

    if (count($socios) == 0) {
        return 1;
    }

    return $socios[count($socios)-1]['idSocio'] + 1;
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
