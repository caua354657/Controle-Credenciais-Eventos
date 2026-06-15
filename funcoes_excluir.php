<?php
    require("conexaoSGBD.php");

    //mostrar cargo por id
    function mostrar_cargo($id)
    {
        global $conexao;
        $sql = "select * from cargos where id = $id";
        $result = $conexao->query($sql);
        $linha = $result->fetch_assoc();
        return $linha;
    }

    //excluir cargo
    function excluir_cargo($id)
    {
        global $conexao;
        $select = "select * from pessoas where cargo_id = $id";
        $dados = $conexao->query($select);
        if($dados->num_rows > 0) 
        {
            return 'ja_associado';
        }
        else
        {
            $sql = "delete from cargos where id = $id";
            return $conexao->query($sql);
        }
    }

    //mostrar tipo por id
    function mostrar_tipo($id)
    {
        global $conexao;
        $sql = "select * from tipo_cadastro where id = $id";
        $resultados = $conexao->query($sql);
        $row = $resultados->fetch_assoc();
        return $row;
    }

    //excluir tipo
    function excluir_tipo($id)
    {
        global $conexao;
        $select = "select * from empresas where tipo_cadastro = $id";
        $informacoes = $conexao->query($select);
        if($informacoes->num_rows > 0)
        {
            return 'ja_associado';
        }
        else
        {
            $sql = "delete from tipo_cadastro where id =" . $_GET['id'];
            return $conexao->query($sql);
        }
    }
?>