<?php
  require("validar_jwt.php");
  $jwt = json_web_token::validar();
  $categoria = $jwt['categoria'];
  $nome_usuario = $jwt['nome_usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>

<nav class="bottom-navigation">
  <?php
    require("conexaoSGBD.php");
    if($jwt->categoria == 'administrador')
    {
      echo '<a href="cargos.php" class="nav-item">
              <i class="bi bi-briefcase"></i>
              <span>Cargos</span>
            </a>
            <a href="tipos.php" class="nav-item">
              <i class="bi bi-tags"></i>
              <span>Tipos</span>
            </a>
            <a href="empresas.php" class="nav-item">
              <i class="bi bi-building"></i>
              <span>Empresas</span>
            </a>
            <a href="pessoas.php" class="nav-item">
              <i class="bi bi-people"></i>
              <span>Pessoas</span>
            </a>
            <a href="usuarios.php" class="nav-item">
              <i class="bi bi-person"></i>
              <span>Usuários</span>
            </a>';
    }
    else
    { 
      echo '<a href="empresas.php" class="nav-item">
              <i class="bi bi-building"></i>
              <span>Empresas</span>
            </a>
            <a href="pessoas.php" class="nav-item">
              <i class="bi bi-people"></i>
              <span>Pessoas</span>
            </a>';
    }
  ?>
</nav>

<nav class="navbar navbar-expand-sm shadow-sm" style="height: 70px; background-color: rgba(255, 209, 58, 1);">
  <div class="container-fluid d-flex align-items-center">
    <a href="inicio.php" class="btn btn-outline-dark btn-sm d-flex align-items-center gap-2 me-3">
      <i class="bi bi-house-fill"></i> <span>Página Inicial</span>
    </a>
    <div class="ms-auto">
        <div class="d-flex align-items-center dropdown">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-5 me-2"></i>
            <strong><?php echo $nome_usuario ?></strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-end text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item text-center" href="trocar_senha.php"><i class="bi bi-key me-1"></i> Trocar Senha</a></li>
            <li><a class="dropdown-item text-center text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i> Sair</a></li>
          </ul>
        </div>
    </div>
  </div>
</nav>

<div class="top-menu-horizontal central">
    <ul class="nav nav-pills" style="display: flex; justify-content: center; flex-wrap: nowrap; background-color: rgba(206, 169, 49, 1); min-width: max-content;">
      <?php 
            if($categoria == 'administrador')
            {  
                echo '<li class="nav-item">
                          <a class="nav-link" id="nav-link" href="cargos.php" style="color: white;">💼 Cargos</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="nav-link" href="tipos.php" style="color: white;">🏷️ Tipos</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="nav-link" href="empresas.php" style="color: white;">🏢 Empresas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="nav-link" href="pessoas.php" style="color: white;">🙎🏽‍♂️ Pessoas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="nav-link" href="usuarios.php" style="color: white;">🙎‍♂️ Usuários</a>
                      </li>';
            }
            else 
            {
                echo '<li class="nav-item">
                        <a class="nav-link" id="nav-link" href="empresas.php" style="color: white;">🏢 Empresas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="nav-link" href="pessoas.php" style="color: white;">🙎🏽‍♂️ Pessoas</a>
                      </li>';
            }
        ?>
      </ul>
</div>

<div id="carouselPrincipal" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-item active">
        <img src="img/credenciamento.png" class="d-block w-100 img-fluid" style="height: 840px;">
    </div>
</div>

</body>
</html>