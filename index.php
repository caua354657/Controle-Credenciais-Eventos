<?php
use Firebase\JWT\JWT;
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<script src="js/index.js"></script>

<div class="container-login">
    <form action="#" method="post">
    <div class="card bg-warning">
        <div class="card-body text-center"><b>Login</b></div>
    </div>
    <div class="mb-4 mt-3">
        <label for="email" class="form-label">✉️ E-mail</label>
        <input type="email" class="form-control" placeholder="Digite o Email" name="email" required autofocus>
    </div>
    <div class="mb-4 senha-container">
        <label for="senha" class="form-label">🗝️ Senha</label>
        <input type="password" class="form-control" id="senha" placeholder="Digite a Senha" name="senha" required>
        <span class="olho" onclick="mostrarOcultarSenha(this)">🙈</span>
    </div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        require("vendor/autoload.php");
        require('conexaoSGBD.php');

        if($conexao->connect_error) 
        {
            echo '<div class="alert alert-warning text-center">
                    <strong>⚠️ Não foi possível conectar ao servidor no momento.<br>Por favor, tente novamente mais tarde.</strong>
                  </div>';
        }
        else
        {
            $email = trim(strip_tags($_POST['email']));
            $senha = $_POST['senha'];

            $sql = "select * from usuarios where usuario='$email'";

            if($resultado = $conexao->query($sql))
            {
                if($resultado->num_rows > 0)
                {
                    $linha = $resultado->fetch_assoc();
                    $hash = $linha['senha'];
                            
                    if(password_verify($senha, $hash))
                    {
                        $id = $linha['id'];
                        $nome = $linha['nome'];
                        $categoria = $linha['categoria'];
                        $id_empresa = $linha['id_empresa'];
                        $_SESSION['jwt'] = JWT::encode(['id' => $id, 'nome' => $nome, 'usuario' => $email, 'categoria' => $categoria , 'id_empresa' => $id_empresa, 'exp' => time() + 3600], 'minha_chave_secreta', 'HS256');
                        header("refresh: 1; url=inicio.php");
                        echo '<div id="overlay">
                                <div class="spinner-grow" style="color: green;" role="status"></div>
                                <div class="spinner-grow" style="color: green;" role="status"></div>
                                <div class="spinner-grow" style="color: green;" role="status"></div>
                            </div>';
                    }
                    else
                        echo '<div class="text-center alert alert-danger">
                                <strong>Senha Incorreta</strong>
                            </div>';  
                }
                else
                    echo '<div class="text-center alert alert-danger">
                            <strong>Usuário não encontrado</strong>
                         </div>';
            }
            else
                echo '<div class="text-center alert alert-danger">
                        <strong>Erro na Consulta.</strong>
                    </div>';
            $conexao->close();
        }
    }
?>

        <button type="submit" class="btn btn-success w-100">Login</button>
        <div class="text-center mt-3">
            <small>Não tem conta? <a href="cadastro_usuarios.php">Cadastre-se</a></small>
        </div>
    </form>
</div>
    
</body>
</html>