<?php
    require("conexaoSGBD.php");

    //cadastro de cargos
    function cadastro_cargos($nome) //$nome é o que o usuário digitar no outro arquivo que voce chamar essa variavel, assim a função sabe o que inserir
    {
        global $conexao; //pega a conexao fora da função
        $sql = "insert into cargos(nome) values('$nome')";
        return $conexao->query($sql);
    }

    //cadastro tipos
    function cadastro_tipos($nome, $controla)
    {
        global $conexao;
        $sql = "insert into tipo_cadastro(nome, controla_espacos) values('$nome','$controla')";
        return $conexao->query($sql);
    }
?>