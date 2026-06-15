<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Alterar Usuário</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/alterar_usuario.css">
</head>
<body>

<?php
    require("conexaoSGBD.php");
    $id_usuario = $_GET['id'];

    $sql = "select * from usuarios where id = $id_usuario";

    if($resultado = $conexao->query($sql))
    {
        $linha = $resultado->fetch_assoc();
        $nome = $linha['nome'];
        $usuario = $linha['usuario'];
        $categoria = $linha['categoria'];
    }
?>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Alterar Usuário</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label for="nome" class="form-label">👤 Nome</label>
            <input type="text" class="form-control" placeholder="Digite o Nome" name="nome" value="<?php echo $nome; ?>" autofocus>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-3">
            <label for="email" class="form-label">✉️ E-mail</label>
            <input type="email" class="form-control" placeholder="Digite o Email" name="email" value="<?php echo $usuario; ?>">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="categoria" class="form-label">Categoria</label>
            <select name="categoria" class="form-select" id="categoria" required>
                <option value="" selected disabled hidden>Selecione a Categoria</option>
                <option value="administrador" <?php if($categoria == "administrador") echo "selected"; ?>>Administrador</option>
                <option value="expositor" <?php if($categoria == "expositor") echo "selected"; ?>>Expositor</option>
            </select>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="empresa" class="form-label">Empresa</label>
            <select name="empresa" class="form-select" id="empresa" required>
                <option value="" disabled hidden>Selecione a Empresa</option>
                <?php
                    $sql = "select * from empresas";
                    if($resultado = $conexao->query($sql))
                    {
                        while($row = $resultado->fetch_assoc())
                        {
                            $id = $row['id'];
                            $nome_empresa = $row['nome_fantasia'];
                            
                            if($empresa == $id)
                                $selected = "selected";
                            else
                                $selected = "";
                                echo '<option value="'.$id.'" '.$selected.'>'.$nome_empresa.'</option>';
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
                $nome = $_POST['nome'];
                $email = trim(strip_tags($_POST['email']));
                $categoria = $_POST['categoria'];
                $empresa = $_POST['empresa'];

                $sql = "update usuarios set usuario = '$email', nome = '$nome', categoria = '$categoria', id_empresa = '$empresa' where id = $id_usuario";

                if($conexao->query($sql))
                {
                    header("refresh: 1; url=usuarios.php");
                    echo '<div id="spinner-overlay">
                            <div id="spinner"></div>
                         </div>';
                    ob_end_flush();
                }
                else
                    echo '<div class="text-center alert alert-danger">
                            <strong>Erro ao executar: '.$conexao->error.'</strong>
                        </div>';
                    $conexao->close();
            }
        ?>

        <div class="d-flex gap-2">
            <a href="usuarios.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-primary w-50">Alterar</button>
        </div>
    </form>
<div>

</body>
</html>