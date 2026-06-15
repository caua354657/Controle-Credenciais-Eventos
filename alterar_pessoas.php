<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Pessoas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_pessoas.css">
</head>
<body>

<?php
    require("conexaoSGBD.php");
    $id_pessoa = $_GET['id'];
    $sql = "select * from pessoas where id = $id_pessoa";
    $result = $conexao->query($sql);
    $linha = $result->fetch_assoc();

    $nome = $linha['nome'];
    $cpf = $linha['cpf'];
    $rg = $linha['rg'];
    $telefone = $linha['telefone'];
    $empresa_id = $linha['empresa_id'];
    $cargo_id = $linha['cargo_id'];
    $ingresso = $linha['ingresso_permanente'];
    $enviado_catraca = $linha['enviado_catraca'];
    $importado = $linha['importado'];
    $impresso = $linha['impresso'];
?>

<script src="js/alterar_pessoas.js"></script>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post" enctype="multipart/form-data">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Alterar Pessoa</b></div>
        </div>
        <div class="mb-4 mt-2">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" placeholder="Digite o nome" name="nome" value="<?php echo $nome; ?>" required autofocus>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" value="<?php echo $cpf; ?>" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="rg" class="form-label">RG</label>
            <input type="text" class="form-control" name="rg" id="rg" placeholder="Digite o RG" value="<?php echo $rg; ?>" required maxlength="9">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone" value="<?php echo $telefone; ?>" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="arquivo" class="form-label">Foto</label>
            <input type="file" name="arquivo" class="form-control">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, envie a foto.</div>
        </div>
        <div class="mb-4">
                <label for="empresa_id" class="form-label">Empresa</label>
                <select name="empresa_id" class="form-select">
                    <option value="" selected disabled hidden>Selecione</option>
                    <?php
                        require("conexaoSGBD.php");
                        $sql = "select id, razao_social from empresas";
                        if($dados = $conexao->query($sql)) 
                        {
                            while($row = $dados->fetch_assoc()) 
                            {
                                $id = $row['id'];
                                if($id == $empresa_id) 
                                {
                                    $selected = 'selected';
                                }
                                echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['razao_social'].'</option>';
                            }
                        }
                    ?>
                </select>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
                <label for="cargo_id" class="form-label">Cargo_ID</label>
                <select name="cargo_id" class="form-select">
                    <option value="" selected disabled hidden>Selecione</option>
                    <?php
                        $sql = "select id, nome from cargos";
                        if($resultado = $conexao->query($sql)) 
                        {
                            while($line = $resultado->fetch_assoc()) 
                            {
                                $id = $line['id'];
                                if($id == $cargo_id) 
                                {
                                    $selecionado = 'selected';
                                }
                                echo '<option value="'.$line['id'].'" '.$selecionado.'>'.$line['nome'].'</option>';
                            }
                        }
                    ?>
                </select>
                <div class="valid-feedback">Válido.</div>
                <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="row">
            <div class="col-6 mb-4">
                <label class="form-label d-block">Ing_Permanente</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ingresso" id="ingresso_s" value="Sim" <?php if($ingresso == 'Sim') echo "checked"; ?>>
                    <label class="form-check-label" for="ingresso_s">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ingresso" id="ingresso_n" value="Não" <?php if($ingresso == 'Não') echo "checked"; ?>>
                    <label class="form-check-label" for="ingresso_n">Não</label>
                </div>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label d-block">Env_Catraca</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="enviado_catraca" value="Sim" <?php if($enviado_catraca == 'Sim') echo "checked"; ?>>
                    <label class="form-check-label">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="enviado_catraca" value="Não" <?php if($enviado_catraca == 'Não') echo "checked"; ?>>
                    <label class="form-check-label">Não</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-4">
                <label class="form-label d-block">Importado</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="importado" value="Sim" <?php if($importado == 'Sim') echo "checked"; ?>>
                    <label class="form-check-label">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="importado" value="Não" <?php if($importado == 'Não') echo "checked"; ?>>
                    <label class="form-check-label">Não</label>
                </div>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label d-block">Impresso</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="impresso" value="Sim" <?php if($impresso == 'Sim') echo "checked"; ?>>
                    <label class="form-check-label">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="impresso" value="Não" <?php if($impresso == 'Não') echo "checked"; ?>>
                    <label class="form-check-label">Não</label>
                </div>
            </div>
        </div>
        

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $telefone = $_POST['telefone'];
                $foto = $_FILES['arquivo']['name'];
                $empresa_id = $_POST['empresa_id'];
                $cargo_id = $_POST['cargo_id'];
                $ingresso = $_POST['ingresso'];
                $enviado_catraca = $_POST['enviado_catraca'];
                $importado = $_POST['importado'];
                $impresso = $_POST['impresso'];
                
                $pasta = "foto/";

                if(!is_dir($pasta)) 
                    mkdir($pasta);

                $foto = $_FILES['arquivo']['name'];
                $uploadfoto = $pasta . $foto;

                if(!empty($_FILES['arquivo']['name']))
                {
                    if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfoto))
                    {
                        $sql = "update pessoas set nome = '$nome', cpf = '$cpf', rg = '$rg', telefone = '$telefone', foto = '$foto', empresa_id = '$empresa_id', cargo_id = '$cargo_id', ingresso_permanente = '$ingresso', enviado_catraca = '$enviado_catraca', importado = '$importado', impresso = '$impresso' where id = $id_pessoa";

                        if($conexao->query($sql))
                        {
                            header("refresh: 1; url=pessoas.php");
                            echo '<div id="spinner-overlay">
                                    <div id="spinner"></div>
                                </div>';
                        }
                        else
                            echo '<div class="text-center alert alert-danger">
                                    <strong>Erro ao executar: '.$conexao->error.'</strong>
                                </div>';
                    }
                }
                else
                {
                    $sql = "update pessoas set nome = '$nome', cpf = '$cpf', rg = '$rg', telefone = '$telefone', empresa_id = '$empresa_id', cargo_id = '$cargo_id', ingresso_permanente = '$ingresso', enviado_catraca = '$enviado_catraca', importado = '$importado', impresso = '$impresso' where id = $id_pessoa";

                        if($conexao->query($sql))
                        {
                            header("refresh: 1; url=pessoas.php");
                            echo '<div id="spinner-overlay">
                                    <div id="spinner"></div>
                                </div>';
                            ob_end_flush();
                        }
                        else
                            echo '<div class="text-center alert alert-danger">
                                    <strong>Erro ao executar: '.$conexao->error.'</strong>
                                </div>';
                }
            }
            $conexao->close();
        ?>

        <div class="d-flex gap-2">
            <a href="pessoas.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-primary w-50">Alterar</button>
        </div>
    </form>
</div>

</body>
</html>