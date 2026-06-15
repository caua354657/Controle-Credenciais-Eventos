<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro Empresa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cadastro_empresa.css">
</head>
<body>

<script src="js/cadastro_empresas.js"></script>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Cadastro Empresas</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label for="campo2" class="form-label">Nome Fantasia</label>
            <input type="text" class="form-control" placeholder="Digite Aqui" required name="fantasia">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-3">
            <label for="campo3" class="form-label">Razão Social</label>
            <input type="text" class="form-control" placeholder="Digite Aqui" required name="social">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-2">
            <label for="cnpj" class="form-label">CNPJ</label>
            <input type="text" class="form-control" placeholder="Digite Aqui" name="cnpj" id="cnpj" required>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-2">
            <label for="tipo" class="form-label">Tipo Cadastro</label>
            <select name="tipo" class="form-select" required>
                <option value="" selected disabled hidden>Selecione</option>
                <?php
                    require("conexaoSGBD.php");
                    $sql = "select id, nome from tipo_cadastro";
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

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $ano = date("Y");
                $fantasia = $_POST['fantasia'];
                $razao = $_POST['social'];
                $tipo_cadastro = $_POST['tipo'];
                $cnpj = $_POST['cnpj'];
                $importado = "Não";

                $select = "select * from empresas where cnpj = '$cnpj'";
                $dados = $conexao->query($select);
                $row = $dados->fetch_assoc();
                
                if($dados->num_rows > 0)
                {
                    echo '<div class="text-center alert alert-danger">
                            <strong>Esse CNPJ já existe.</strong>
                        </div>';
                }
                else
                {
                    $sql = "insert into empresas(ano, nome_fantasia, razao_social, tipo_cadastro, cnpj, importado) values('$ano','$fantasia','$razao','$tipo_cadastro','$cnpj','$importado')";

                    if($conexao->query($sql))
                    {
                        header("refresh: 1; url=empresas.php");
                        echo '<div id="spinner-overlay">
                                <div id="spinner"></div>
                            </div>';
                    }
                    else
                        echo '<div class="text-center alert alert-danger">
                                <strong>Erro ao executar: '.$conexao->error.'</strong>
                            </div>';
                        $conexao->close();
                }
            }
        ?>

        <div class="d-flex gap-2">
            <a href="empresas.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Cadastrar</button>
        </div>
    </form>
<div>

</body>
</html>