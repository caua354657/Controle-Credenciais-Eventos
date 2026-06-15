<?php
  require('vendor/autoload.php'); //composer
  require('conexaoSGBD.php'); //banco dados
  $empresa = $_GET['id'];
  use Dompdf\Dompdf;
  $dompdf = new Dompdf();

  $registros = $_GET['numero'];
  $html = '<!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Relatório de Usuários por Empresa</title>
            <style> 
                @page {margin: 7;}

                body{font-family: Arial, sans-serif;
                    font-size: 12px;}
                
                h2{text-align: center;
                   margin-bottom: 20px;}
                
                table{width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;}

                th, td{border: 1px solid #333;
                       padding: 6px;
                       text-align: center;
                       vertical-align: middle;}
                
                th{background-color: #f2f2f2;
                    font-weight: bold;}
            </style>
        </head>
        <body> 
                <h2>Relatório Pessoas por Empresa</h2>  
                <p><b>Número de Registros:</b> '.$registros.'</p>      
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Empresa</th>
                        </tr>
                    </thead>
                    <tbody>';

  $sql = "select usuarios.id, usuarios.usuario, usuarios.nome, usuarios.categoria, empresas.razao_social as nome_empresa from usuarios join empresas on empresas.id = usuarios.id_empresa where usuarios.id_empresa = '$empresa'";
  $resultado = $conexao->query($sql);

  while($linha = $resultado->fetch_assoc())
  {
    $html .='<tr>
                <td>'.$linha['id'].'</td>
                <td>'.$linha['usuario'].'</td>
                <td>'.$linha['nome'].'</td>
                <td>'.$linha['categoria'].'</td>
                <td>'.$linha['nome_empresa'].'</td>
            </tr>';
  }

  $html .= '</tbody>
           </table>
            </body>
            </html>';

  $conexao->close();

  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4'); //tipo de papel
  $dompdf->render(); //renderizar 
  $dompdf->stream(); //download 