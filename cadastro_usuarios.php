<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro Usuário</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="css/cadastro_usuario.css">
</head>
<body>

<div class="container-cadastro">
    <form action="#" class="was-validated" method="post">
        <div class="card bg-warning">
            <div class="card-body text-center"><b>Cadastro Usuários</b></div>
        </div>
        <div class="mb-4 mt-3">
            <label for="nome" class="form-label">👤 Nome</label>
            <input type="text" class="form-control" placeholder="Digite o Nome" required name="nome" autofocus>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4 mt-3">
            <label for="email" class="form-label">✉️ E-mail</label>
            <input type="email" class="form-control" placeholder="Digite o Email" required name="email">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="senha" class="form-label">🗝️ Senha</label>
            <input type="password" class="form-control" placeholder="Digite a Senha" required name="senha">
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="categoria" class="form-label">Categoria</label>
            <select name="categoria" class="form-select" id="categoria" required>
                <option value="" selected disabled hidden>Selecione a Categoria</option>
                <option value="administrador">Administrador</option>
                <option value="expositor">Expositor</option>
            </select>
            <div class="valid-feedback">Válido.</div>
            <div class="invalid-feedback">Por favor, preencha este campo.</div>
        </div>
        <div class="mb-4">
            <label for="empresa" class="form-label">Empresa</label>
            <select name="empresa" class="form-select" id="empresa" required>
                <option value="" selected disabled hidden>Selecione a Categoria</option>
                <?php
                    require("conexaoSGBD.php");
                    $sql = "select * from empresas";
                    if($resultado = $conexao->query($sql))
                    {
                        while($linha = $resultado->fetch_assoc())
                        {
                            $id = $linha['id'];
                            $nome_empresa = $linha['nome_fantasia'];
                            echo'<option value="'.$id.'">'.$nome_empresa.'</option>';
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
                $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                $categoria = $_POST['categoria'];
                $id_empresa = $_POST['empresa'];

                $sql = "insert into usuarios(nome, usuario, senha, categoria, id_empresa) values('$nome','$email','$senha','$categoria', '$id_empresa')";

                if($conexao->query($sql))
                {
                    header("refresh: 1; url=usuarios.php");
                    echo '<div id="spinner-overlay">
                            <div id="spinner"></div>
                         </div>';
                }
                else
                    echo '<div class="text-center alert alert-danger">
                            <strong>Esse E-mail já existe. Tente Outro</strong>
                        </div>';
                    $conexao->close();
            }
        ?>

        <div class="d-flex gap-2">
            <a href="javascript:window.history.back()" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-success w-50">Cadastrar</button>
        </div>
        <div class="text-center mt-3">
            <small>Já tem conta? <a href="index.php">Faça Login</a></small>
        </div>
    </form>
<div>

</body>
</html>