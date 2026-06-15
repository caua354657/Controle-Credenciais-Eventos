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
    <title>Usuários por Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/ver_usuarios.css">
</head>
<body>

<nav class="bottom-navigation">
  <?php
    require("conexaoSGBD.php");
    $id_empresa = $_GET['id']; //usar para mostrar os usuarios por empresa direto

    if($categoria == 'administrador')
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
            <li><a class="dropdown-item text-center" href="trocar_senha.php"><i class="bi bi-key me-1"></i>Trocar Senha</a></li>
            <li><a class="dropdown-item text-center text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Sair</a></li>
          </ul>
        </div>
    </div>
  </div>
</nav>

<div class="d-flex">
  <div class="sidebar">
        <?php
          if($categoria == 'administrador')
          {
            echo '<a href="cargos.php" class="menu-item">💼 Cargos</a>
                  <a href="tipos.php" class="menu-item logout">🏷️ Tipos</a>
                  <a href="empresas.php" class="menu-item logout">🏢 Empresas</a>
                  <a href="pessoas.php" class="menu-item">🙎🏽‍♂️ Pessoas</a>
                  <a href="usuarios.php" class="menu-item logout">👤 Usuários</a>';
          }
          else 
          {
            echo '<a href="empresas.php" class="menu-item logout">🏢 Empresas</a>
                  <a href="pessoas.php" class="menu-item">🙎🏽‍♂️ Pessoas</a>';
          }
      ?>
  </div>

<?php 
    $sql = "select id from usuarios where id_empresa = $id_empresa";
    $result = $conexao->query($sql);
    $registros = $result->num_rows;

    echo '<div id="container-tabela">
            <h3>🏢 Empresas</h3>
            <div class="d-flex justify-content-between">
              <div class="d-flex gap-2">
                  <a href="cadastro_usuarios.php" class="btn btn-success">Inserir Usuários</a>
                  <a href="relatorio_usuarios_por_empresa_pdf.php?id='.$id_empresa.'&numero='.$registros.'" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down"></i> Relatório</a>
              </div>
              <a href="empresas.php" class="btn btn-outline-secondary">🡄 Voltar</a>
            </div>';
                                                        
            $sql = "select usuarios.id, usuarios.nome, usuarios.usuario, usuarios.categoria, empresas.nome_fantasia as empresa from usuarios join empresas on empresas.id = usuarios.id_empresa where usuarios.id_empresa = $id_empresa";

            if($resultado = $conexao->query($sql)) 
            {
                if($resultado->num_rows > 0)
                {
                      echo '<br>';
                      echo '<div id="tabela-responsiva">';
                      echo '<table class="table table-striped table-hover table-bordered">
                              <thead class="text-center">
                                              <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>E-mail</th>
                                                <th>Empresa</th>
                                                <th>Função</th>
                                              </tr>
                                            </thead>
                                            <tbody class="text-center">';
                        while($row = $resultado->fetch_assoc()) 
                        {
                            echo '<tr>
                                    <td>'.$row['id'].'</td>
                                    <td>'.$row['nome'].'</td>
                                    <td>'.$row['usuario'].'</td>
                                    <td>'.$row['empresa'].'</td>
                                    <td>'.$row['categoria'].'</td>
                                </tr>';
                        }
                        echo '</tbody>
                              </table>
                              </div>';
                }
                else
                {
                    echo '<br>';
                    echo '<div class="alert alert-warning">
                            <strong>Nenhum usuário pertencente nessa Empresa.</strong>
                          </div>';
                }
            }
            $conexao->close();
?>

</div>

</body>
</html>