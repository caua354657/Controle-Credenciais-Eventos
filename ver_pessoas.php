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
    <title>Pessoas por Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/ver_pessoas.css">
</head>
<body>

<nav class="bottom-navigation">
  <?php
    require("conexaoSGBD.php");
    $empresa = $_GET['id']; //usar para mostrar as pessoa por empresa direto

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
    $sql = "select id from pessoas where empresa_id = $empresa";
    $result = $conexao->query($sql);
    $registros = $result->num_rows;
  
    echo '<div id="container-tabela">
            <h3>🏢 Empresas</h3>
            <div class="d-flex justify-content-between">
              <div class="d-flex gap-2">
                  <a href="cadastro_pessoas.php" class="btn btn-success">Inserir Pessoas</a>
                  <a href="relatorio_pessoas_por_empresa_pdf.php?id='.$empresa.'&numero='.$registros.'" class="btn btn-primary"><i class="bi bi-file-earmark-arrow-down"></i> Relatório</a>
              </div>
              <a href="empresas.php" class="btn btn-outline-secondary">🡄 Voltar</a>
            </div>';
                                                        
            $sql = "select pessoas.id, pessoas.foto, pessoas.nome, pessoas.cpf, empresas.razao_social, cargos.nome as cargo from pessoas join empresas on pessoas.empresa_id = empresas.id join cargos on pessoas.cargo_id = cargos.id where pessoas.empresa_id = $empresa order by pessoas.id";

            if($resultado = $conexao->query($sql)) 
            {
                echo '<br>';

                if($resultado->num_rows > 0)
                {
                      echo '<div id="tabela-responsiva">';
                      echo '<table class="table table-striped table-hover table-bordered">
                              <thead class="text-center">
                                              <tr>
                                                <th>ID</th>
                                                <th>Foto</th>
                                                <th>Nome</th>
                                                <th>CPF</th>
                                                <th>Empresa</th>
                                                <th>Cargo</th>
                                              </tr>
                                            </thead>
                                            <tbody class="text-center">';
                        while($row = $resultado->fetch_assoc()) 
                        {
                            $id = $row['id'];
                            echo '<tr>
                                    <td>'.$id.'</td>
                                    <td><img src="foto/'.$row["foto"].'" width="100"></td>
                                    <td>'.$row['nome'].'</td>
                                    <td>'.$row['cpf'].'</td>
                                    <td>'.$row['razao_social'].'</td>
                                    <td>'.$row['cargo'].'</td>
                                </tr>';
                        }
                        echo '</tbody>
                              </table>
                              </div>';
                }
                else
                {
                    echo '<div class="alert alert-warning">
                            <strong>Nenhuma pessoa pertencente nessa Empresa.</strong>
                          </div>';
                }
            }
            $conexao->close();
?>

</div>

</body>
</html>