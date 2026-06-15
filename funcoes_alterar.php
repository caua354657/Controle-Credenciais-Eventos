<?php
    require("conexaoSGBD.php");

    //mostrar o cargo com aquele id
    function mostrar_cargo($id)
    {
        global $conexao;
        $sql = "select * from cargos where id = $id";
        $result = $conexao->query($sql);
        $linha = $result->fetch_assoc();
        return $linha;
    }

    //alterar cargos
    function alterar_cargos($nome, $id)
    {
        global $conexao;
        $sql = "update cargos set nome = '$nome' where id = ". $id;
        return $conexao->query($sql);
    }

    //mostrar_tipos por id
    function mostrar_tipos($id)
    {
        global $conexao;
        $sql = "select * from tipo_cadastro where id = $id";
        $dados = $conexao->query($sql);
        $line = $dados->fetch_assoc();
        return $line;
    }

    //alterar tipos
    function alterar_tipos($nome, $controla, $id)
    {
        global $conexao;
        $sql = "update tipo_cadastro set nome = '$nome', controla_espacos = '$controla' where id = ". $id;
        return $conexao->query($sql);
    }
?>