<?php
    session_start();
    require('vendor/autoload.php');
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Firebase\JWT\ExpiredException;

    if(isset($_SESSION['jwt'])) 
    {
      $token = $_SESSION['jwt'];
      try //parte do código que pode causar erro
      {
        $tokendecodificado = JWT::decode($token, new Key('minha_chave_secreta', 'HS256'));
        if(isset($tokendecodificado->id))
        {
          $usuario_id = $tokendecodificado->id;
        }
      }                    
      catch(ExpiredException $erro) //o que fazer
      {
        session_destroy();
        header('refresh: 0.1; url=index.php');
        echo '<script>alert("Sua sessão expirou. Faça login novamente!")</script>';
        exit;
      }
    }
    else 
    {
        header("refresh:1; url=index.php");
        echo '<script>alert("Token não enviado")</script>';
        exit;
    }    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trocar Senha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/trocar_senha.css">
</head>
<body>

<div class="container-alterar">
    <form action="#" method="post">
    <div class="card bg-warning">
        <div class="card-body text-center"><b>Alterar</b></div>
    </div>
    <div class="mb-4 mt-3">
        <label for="senha" class="form-label">🗝️ Senha Atual</label>
        <input type="password" class="form-control" placeholder="Digite a Senha Atual" name="senha_atual" required autofocus>
    </div>
    <div class="mb-4">
        <label for="senha" class="form-label">🗝️ Nova Senha</label>
        <input type="password" class="form-control" placeholder="Digite a Senha Nova" name="nova_senha" required>
    </div>

<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        require("conexaoSGBD.php");
        $senha_atual = $_POST['senha_atual']; 
        $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

        $id = $usuario_id;
        $sql = "select senha from usuarios where id = $id";
        if($result = $conexao->query($sql))
        {
            $linha = $result->fetch_assoc();
            $senha_BD = $linha['senha'];
        }

        if(password_verify($senha_atual, $senha_BD))
        {
            $sql = "update usuarios set senha = '$nova_senha' where id = $id";

            if($result = $conexao->query($sql))
            {
                header ("refresh: 1; url=index.php");
                echo '<div id="spinner-overlay">
                        <div id="spinner"></div>
                      </div>';
            }
            else 
                echo '<div class="alert alert-danger mt-4">
                        <strong>Erro na Consulta.</strong>.
                    </div>';
        }
        else
            echo '<div class="alert alert-danger mt-4 text-center">
                     <strong>Senha atual Incorreta.</strong>.
                  </div>';
            $conexao->close();
    }
?>

    <div class="d-flex gap-2">
        <a href="inicio.php" class="btn btn-secondary w-50">Voltar</a>
        <button type="submit" class="btn btn-success w-50">Alterar</button>
    </div>
    </form>
</div>

</body>
</html>