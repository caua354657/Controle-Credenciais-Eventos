<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Tipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/excluir_tipos.css">
</head>
<body>

<div class="container-excluir">

<?php
    require("funcoes_excluir.php");
    $id = $_GET['id'];
    if(function_exists('mostrar_tipo'))
    {   
        $row = mostrar_tipo($id);
        $nome = $row['nome'];
    }
?>

    <form action="#" method="post">
        <div class="card bg-danger text-white">
            <div class="card-body text-center"><b>Excluir Tipo Cadastro</b></div>
        </div>
        <div class="mt-3 p-3 border rounded bg-light text-center">
            <p class="text-danger mb-3">Isso resultará na perda dos dados!</p>
            <h5 class="text-primary fw-bold"><?php echo $nome; ?></h5>
        </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST') 
            {
                if(function_exists('excluir_tipo')) 
                {
                    $resultado = excluir_tipo($id);

                    if($resultado === 'ja_associado') 
                    {
                        echo '<div class="text-center alert alert-danger">
                                <strong>Já existe uma empresa associada a esse tipo. Não é possível excluir</strong>
                            </div>';
                    } 
                    elseif($resultado === true) 
                    {
                        header("refresh: 1; url=tipos.php");
                        echo '<div id="spinner-overlay">
                                <div id="spinner"></div>
                            </div>';
                    } 
                    else 
                    {
                        echo '<div class="text-center alert alert-danger">
                                <strong>Erro ao excluir: ' . $conexao->error . '</strong>
                            </div>';
                    }
                }
            }
            $conexao->close();
        ?>

        <div class="d-flex mt-3 gap-2">
            <a href="tipos.php" class="btn btn-secondary w-50">Voltar</a>
            <button type="submit" class="btn btn-danger w-50">Excluir</button>
        </div>
    </form>
</div>
    
</body>
</html>