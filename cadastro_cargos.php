<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro Cargos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cadastro_cargos.css">
</head>
<body>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Cadastro Cargos</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label for="campo2" class="form-label">Nome</label>
            <input type="text" class="form-control" placeholder="Digite o Nome" required name="nome">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                require('funcoes_cadastro.php');
                $nome = $_POST['nome'];

                if(function_exists('cadastro_cargos') and cadastro_cargos($nome))
                {
                    header("refresh: 1; url=cargos.php");
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
            <a href="cargos.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Cadastrar</button>
        </div>
    </form>
<div>

</body>
</html>