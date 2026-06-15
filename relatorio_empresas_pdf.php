<?php
  require('vendor/autoload.php'); //composer
  require('conexaoSGBD.php'); //banco dados
  use Dompdf\Dompdf;
  $dompdf = new Dompdf();

  $registros = $_GET['numero'];
  $html = '<!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Relatório de Pessoas</title>
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
                <h2>Relatório Total Empresas</h2>
                <p><b>Número Registros:</b> '.$registros.'</p>        
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Ano</th>
                            <th>Nome Fantasia</th>
                            <th>Razão Social</th>
                            <th>Tipo Cadastro</th>
                            <th>CNPJ</th>
                            <th>Importado</th>
                        </tr>
                    </thead>
                    <tbody>';

  $sql = "select empresas.id, empresas.ano, empresas.nome_fantasia, empresas.razao_social, tipo_cadastro.nome as nome_tipo, empresas.cnpj, empresas.importado from empresas join tipo_cadastro on tipo_cadastro.id = empresas.tipo_cadastro";
  $resultado = $conexao->query($sql);

  while($linha = $resultado->fetch_assoc())
  {
    $html .='<tr>
                <td>'.$linha['id'].'</td>
                <td>'.$linha['ano'].'</td>
                <td>'.$linha['nome_fantasia'].'</td>
                <td>'.$linha['razao_social'].'</td>
                <td>'.$linha['nome_tipo'].'</td>
                <td>'.$linha['cnpj'].'</td>
                <td>'.$linha['importado'].'</td>
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