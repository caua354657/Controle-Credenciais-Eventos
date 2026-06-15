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
    <title>Empresas Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/empresas.css">
</head>
<body>

<script src="js/empresas.js"></script>

<nav class="bottom-navigation">
  <?php
    require("conexaoSGBD.php");
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
    $sql = "select id from empresas";
    $result = $conexao->query($sql);
    $registros = $result->num_rows;

    echo '<div id="container-tabela">
            <h3>🏢 Empresas</h3>
            <div class="d-flex justify-content-between">
              <div>
                <a href="cadastro_empresas.php" class="btn btn-success">Novo</a>
                <a href="relatorio_empresas_pdf.php?numero='.$registros.'" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down"></i> Relatório</a>
              </div>
              <div class="mb-1">
                  <div class="input-group shadow-sm" id="campo-pesquisa" style="max-width: 350px;">
                      <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Pesquisar...">
                      <span class="input-group-text bg-primary text-white">🔍</span>
                  </div>
                </div>
            </div>';

            if($categoria == 'administrador')
              $sql = "select empresas.id, empresas.nome_fantasia, tipo_cadastro.nome as nome_tipo, empresas.importado from empresas join tipo_cadastro on empresas.tipo_cadastro = tipo_cadastro.id";
            else
              $sql = "select empresas.id, empresas.nome_fantasia, tipo_cadastro.nome as nome_tipo, empresas.importado from empresas join tipo_cadastro on empresas.tipo_cadastro = tipo_cadastro.id join usuarios on empresas.id = usuarios.id_empresa where usuarios.id = $usuario_id";

            if($resultado = $conexao->query($sql))
            {
              $registros = $resultado->num_rows;
              echo "<div class='d-flex justify-content-between'>
                        <p class='mt-2'><b>Registros:</b> ".$registros."</p>
                        <p class='mt-2 fw-bold'>Filtro por Nome Fantasia</p>
                    </div>";
              if($resultado->num_rows > 0)
              {
                  echo '<div id="tabela-responsiva">';
                              echo '<table id="myTable" class="table table-striped table-hover table-bordered">
                                          <thead class="text-center">
                                            <tr>
                                              <th>ID</th>
                                              <th>Nome Fantasia</th>
                                              <th>Tipo Cadastro</th>
                                              <th>Importado</th>
                                              <th>Usuários/Pessoas</th>
                                              <th>Ações</th>
                                            </tr>
                                          </thead>
                                          <tbody class="text-center">';

                  while($linha = $resultado->fetch_assoc())
                  {
                      $id = $linha['id'];
                      echo '<tr>
                              <td>'.$id.'</td>
                              <td>'.$linha['nome_fantasia'].'</td>
                              <td>'.$linha['nome_tipo'].'</td>
                              <td>'.$linha['importado'].'</td>';
                              if($categoria == "administrador")
                              {
                                echo '<td>
                                          <a href="ver_usuarios.php?id='.$id.'" class="btn btn-outline-dark mt-2 mt-sm-0"><i class="bi bi-person"></i></a>
                                          <a href="ver_pessoas.php?id='.$id.'" class="btn btn-outline-dark mt-2 mt-sm-0"><i class="bi bi-people"></i></a>
                                      </td>';
                              }
                              else
                              {
                                echo '<td>
                                          <a href="ver_pessoas.php?id='.$id.'" class="btn btn-outline-dark mt-2 mt-sm-0"><i class="bi bi-people"></i></a>
                                      </td>';
                              }
                              echo '<td>
                                        <a href="alterar_empresa.php?id='.$id.'" class="btn btn-outline-primary mt-2 mt-sm-0"><i class="bi bi-pencil-square"></i></a>
                                        <a href="excluir_empresa.php?id='.$id.'" class="btn btn-outline-danger mt-2 mt-sm-0"><i class="bi bi-x-circle"></i></a>
                                    </td>
                            </tr>';
                  }
                  echo '</tbody>
                    </table>
                    </div>';
              }
              else
              echo '<div class="alert alert-warning">
                        <strong>Nenhum Resultado.</strong>
                    </div>';
            }
            $conexao->close();
    ?>

</div>

</body>
</html>