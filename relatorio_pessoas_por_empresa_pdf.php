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
            <title>Relatório de Pessoas por Empresa</title>
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

                img{border-radius: 8px;
                    border: 1px solid #ccc;}
            </style>
        </head>
        <body> 
                <h2>Relatório Pessoas por Empresa</h2>  
                <p><b>Número de Registros:</b> '.$registros.'</p>      
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Ano</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>RG</th>
                            <th>Telefone</th>
                            <th>Importado</th>
                            <th>Impresso</th>
                            <th>Enviado Catraca</th>
                        </tr>
                    </thead>
                    <tbody>';

  $sql = "select pessoas.id, pessoas.empresa_id, pessoas.ano, empresas.razao_social as razao_social, cargos.nome as cargo, pessoas.foto, pessoas.nome, pessoas.cpf, pessoas.rg, pessoas.telefone, pessoas.importado, pessoas.impresso, pessoas.enviado_catraca from pessoas join cargos on pessoas.cargo_id = cargos.id join empresas on pessoas.empresa_id = empresas.id where pessoas.empresa_id = '$empresa' order by pessoas.id";
  $resultado = $conexao->query($sql);

  while($linha = $resultado->fetch_assoc())
  {
    $foto = $linha['foto'];
    $caminhoFoto = 'foto/'.$foto;
    $fotoBase64 = base64_encode(file_get_contents($caminhoFoto));

    $html .='<tr>
                <td>'.$linha['id'].'</td>
                <td>'.$linha['ano'].'</td>
                <td>'.$linha['razao_social'].'</td>
                <td>'.$linha['cargo'].'</td>
                <td><img src="data:image/jpeg;base64,'.$fotoBase64.'" width="65px" height="65px"></td>
                <td>'.$linha['nome'].'</td>
                <td>'.$linha['cpf'].'</td>
                <td>'.$linha['rg'].'</td>
                <td>'.$linha['telefone'].'</td>
                <td>'.$linha['importado'].'</td>
                <td>'.$linha['impresso'].'</td>
                <td>'.$linha['enviado_catraca'].'</td>
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