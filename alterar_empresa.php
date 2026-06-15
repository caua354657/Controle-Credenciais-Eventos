<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Empresa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_empresa.css">
</head>
<body>

<script src="js/alterar_empresa.js"></script>

<?php
    require("conexaoSGBD.php");
    $id = $_GET['id'];

    $sql = "select * from empresas where id = $id";

    if($resultado = $conexao->query($sql))
    {
        $linha = $resultado->fetch_assoc();
        $nome_fantasia = $linha['nome_fantasia'];
        $razao_social = $linha['razao_social'];
        $cnpj = $linha['cnpj'];
        $tipo_cadastro = $linha['tipo_cadastro'];
    }
?>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Alterar Empresa</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label class="form-label">🏪 Nome Fantasia</label>
            <input type="text" class="form-control" name="fantasia" value="<?php echo $nome_fantasia; ?>" placeholder="Digite o Nome Fantasia">
        </div>
        <div class="mb-4">
            <label class="form-label">📄 Razão Social</label>
            <input type="text" class="form-control" name="social" value="<?php echo $razao_social; ?>" placeholder="Digite a Razão Social">
        </div>
        <div class="mb-4 mt-3">
            <label class="form-label">🔢 CNPJ</label>
            <input type="text" class="form-control" name="cnpj" id="cnpj" value="<?php echo $cnpj; ?>" placeholder="Digite o CNPJ" maxlength="18">
        </div>
        <div class="mb-4">
            <label class="form-label">🏷️ Tipo Cadastro</label>
            <select name="tipo" class="form-select">
                <option value="" selected>Selecione a Categoria</option>
                <?php
                    $sql = "select id, nome from tipo_cadastro";
                    if($result = $conexao->query($sql)) 
                    {
                        while($row = $result->fetch_assoc()) 
                        {
                            if($tipo_cadastro == $row['id']) 
                                $selected = "selected";
                            else 
                                $selected = "";
                                echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['nome'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $fantasia = $_POST['fantasia'];
                $razao = $_POST['social'];
                $cnpj = $_POST['cnpj'];
                $tipo_cadastro = $_POST['tipo'];

                $sql = "update empresas set nome_fantasia = '$fantasia', razao_social = '$razao', cnpj = '$cnpj', tipo_cadastro = '$tipo_cadastro' where id = $id";

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
        ?>

        <div class="d-flex gap-2">
            <a href="empresas.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-primary w-50">Alterar</button>
        </div>
    </form>
<div>

</body>
</html>