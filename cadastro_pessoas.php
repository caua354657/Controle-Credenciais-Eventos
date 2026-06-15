<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro Pessoas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cadastro_pessoas.css">
</head>
<body>

<script src="js/cadastro_pessoas.js"></script>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post" enctype="multipart/form-data">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Cadastro Pessoas</b></div>
        </div>
        <div class="mb-4 mt-2">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" placeholder="Digite o nome" name="nome" required autofocus>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="rg" class="form-label">RG</label>
            <input type="text" class="form-control" name="rg" id="rg" placeholder="Digite o RG" required maxlength="9">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Digite o telefone" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="arquivo" class="form-label">Foto</label>
            <input type="file" name="arquivo" class="form-control">
            <div class="valid-feedback">Campo Opcional</div>
        </div>
        <div class="mb-4">
            <label for="empresa_id" class="form-label">Empresa</label>
            <select name="empresa_id" class="form-select" required>
                <option value="" selected disabled hidden>Selecione</option>
                <?php
                    require("conexaoSGBD.php");
                    $sql = "select id, razao_social from empresas";
                    if($resultado = $conexao->query($sql)) 
                    {
                        while($linha = $resultado->fetch_assoc()) 
                        {
                            echo '<option value="'.$linha['id'].'">'.$linha['razao_social'].'</option>';
                        }
                    }
                ?>
            </select>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="cargo_id" class="form-label">Cargo</label>
            <select name="cargo_id" class="form-select" required>
                <option value="" selected disabled hidden>Selecione</option>
                <?php
                    $sql = "select id, nome from cargos";
                    if($resultado = $conexao->query($sql)) 
                    {
                        while($linha = $resultado->fetch_assoc()) 
                        {
                            echo '<option value="'.$linha['id'].'">'.$linha['nome'].'</option>';
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
                <input class="form-check-input" type="radio" name="ingresso" id="ingresso_sim" value="Sim" required>
                <label class="form-check-label" for="ingresso_sim">Sim</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ingresso" id="ingresso_nao" value="Não" required>
                <label class="form-check-label" for="ingresso_nao">Não</label>
            </div>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label d-block">Env_Catraca</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="enviado_catraca" id="catraca_sim" value="Sim" required>
                    <label class="form-check-label" for="catraca_sim">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="enviado_catraca" id="catraca_nao" value="Não" required>
                    <label class="form-check-label" for="catraca_nao">Não</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mb-4">
                <label class="form-label d-block">Importado</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="importado" id="importado_sim" value="Sim" required>
                    <label class="form-check-label" for="importado_sim">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="importado" id="importado_nao" value="Não" required>
                    <label class="form-check-label" for="importado_nao">Não</label>
                </div>
            </div>
            <div class="col-6 mb-4">
                <label class="form-label d-block">Impresso</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="impresso" id="impresso_sim" value="Sim" required>
                    <label class="form-check-label" for="impresso_sim">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="impresso" id="impresso_nao" value="Não" required>
                    <label class="form-check-label" for="impresso_nao">Não</label>
                </div>
            </div>
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $ano = date("Y");
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $telefone = $_POST['telefone'];
                $empresa_id = $_POST['empresa_id'];
                $cargo_id = $_POST['cargo_id'];
                $ingresso = $_POST['ingresso'];
                $enviado_catraca = $_POST['enviado_catraca'];
                $importado = $_POST['importado'];
                $impresso = $_POST['impresso'];
                
                $pasta = "foto/";

                if(!is_dir($pasta)) 
                    mkdir($pasta);

                $foto = uniqid() . "-" . $_FILES['arquivo']['name'];
                $uploadfoto = $pasta . $foto;

                $select = "select * from pessoas where cpf = '$cpf' or rg = '$rg'";
                $result = $conexao->query($select);
                $linha = $result->fetch_assoc();

                if($result->num_rows > 0)
                {
                    echo '<div class="text-center alert alert-danger">
                            <strong>CPF ou RG já existe.</strong>
                        </div>';
                }
                else
                {
                    if(!empty($_FILES['arquivo']['name']))
                    {
                        if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfoto))
                        {
                            $sql = "insert into pessoas(ano, nome, cpf, rg, telefone, foto, empresa_id, cargo_id, ingresso_permanente, enviado_catraca, importado, impresso, impresso_em, criado_em, atualizado_em, excluido_em, cad_biometria_em, env_catraca_em) values('$ano','$nome','$cpf','$rg','$telefone','$foto','$empresa_id','$cargo_id','$ingresso','$enviado_catraca','$importado','$impresso', current_timestamp,current_timestamp,current_timestamp,current_timestamp,current_timestamp,current_timestamp)";

                            if($conexao->query($sql))
                            {
                                header("refresh: 1; url=pessoas.php");
                                echo '<div id="spinner-overlay">
                                        <div id="spinner"></div>
                                    </div>';
                            }
                            else
                                echo '<div class="text-center alert alert-danger">
                                        <strong>Esse CPF já existe</strong>
                                    </div>';
                        }
                    }
                    else
                    {
                        $sql = "insert into pessoas(ano, nome, cpf, rg, telefone, foto, empresa_id, cargo_id, ingresso_permanente, enviado_catraca, importado, impresso, impresso_em, criado_em, atualizado_em, excluido_em, cad_biometria_em, env_catraca_em) values('$ano','$nome','$cpf','$rg','$telefone','$foto','$empresa_id','$cargo_id','$ingresso','$enviado_catraca','$importado','$impresso', current_timestamp,current_timestamp,current_timestamp,current_timestamp,current_timestamp,current_timestamp)";

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
            }
            ob_end_flush();
            $conexao->close();
        ?>

        <div class="d-flex gap-2">
            <a href="javascript:history.back()" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Cadastrar</button>
        </div>
    </form>
</div>

</body>
</html>