<?php
  require('vendor/autoload.php'); //composer
  require("phpqrcode/qrlib.php"); //biblioteca qr_code
  require('conexaoSGBD.php'); //banco dados
  use Dompdf\Dompdf;
  $dompdf = new Dompdf();

  $id_pessoa = (int) $_POST['id_pessoa'];
  $sql = "select pessoas.foto, pessoas.nome, pessoas.telefone, empresas.razao_social as empresa, cargos.id as id_cargo, cargos.nome as cargo from pessoas join empresas on empresas.id = pessoas.empresa_id join cargos on cargos.id = pessoas.cargo_id where pessoas.id = $id_pessoa";
  $resultado = $conexao->query($sql);
  $linha = $resultado->fetch_assoc();
  
  $foto = $linha['foto'];
  $caminhoFoto = 'foto/'.$foto;
  $fotoBase64 = base64_encode(file_get_contents($caminhoFoto));
  $nome = $linha['nome'];
  $telefone = $linha['telefone'];
  $empresa = $linha['empresa'];
  $cargo = $linha['cargo'];

  $pasta = "qrcodes/";
  if(!file_exists($pasta)) 
      mkdir($pasta);

  if(isset($_POST['id_pessoa'], $_POST['id_empresa'], $_POST['cpf'])) 
  {
      $qrText = "ID_Pessoa = ".$_POST['id_pessoa']. "\n" ."ID_Empresa = ".$_POST['id_empresa']. "\n" ."ID_Cargo = ".$linha['id_cargo']. "\n" ."CPF = ".$_POST['cpf'];

      $arquivoQR = $pasta.'qr_pessoa_'.$_POST['id_pessoa'].'.png';

      QRcode::png($qrText, $arquivoQR, QR_ECLEVEL_L, 5);

      $qrCodeBase64 = base64_encode(file_get_contents($arquivoQR)); //transforma imagem, arquivos... em texto
  }

  $dompdf->loadHtml('<!DOCTYPE html>
                      <html lang="pt-br">
                      <head>
                        <meta charset="UTF-8">
                        <title>Crachá</title>
                      </head>
                      <body>
                       
                      <div style="width: 350px; margin: 0 auto; font-family: Arial, sans-serif; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                          <div style="background-color: #ffc107; padding: 10px; text-align: center; font-weight: bold; font-size: 1.2em; border-top-left-radius: 8px; border-top-right-radius: 8px; position: relative; z-index: 2;">Credencial</div>
                          
                          <div style="padding: 15px; margin-top: 30px; overflow: visible;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                              <img src="data:image/jpeg;base64,'.$fotoBase64.'" style="width: 160px; height: 160px; border: 2px solid #007bff; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.2); object-fit: cover; margin-right: 10px;">
                              <img src="data:image/png;base64,'.$qrCodeBase64.'" style="width: 100px; height: 100px; border: 1px solid #000; box-shadow: 0 0 5px rgba(0,0,0,0.2); margin-left: 15px; position: relative; top: -25px;">
                            </div>
                            <hr style="border: none; border-top: 1px solid #ddd; margin: 0 0 4px 0;">
                            <div style="font-size: 0.9em; line-height: 1.4em; color: #333;">
                              <p><strong>ID Pessoa:</strong> '.$id_pessoa.'</p>
                              <p><strong>Nome:</strong> '.$nome.'</p>
                              <p><strong>Telefone:</strong> '.$telefone.'</p>
                              <p><strong>Empresa:</strong> '.$empresa.'</p>
                              <p><strong>Cargo:</strong> '.$cargo.'</p>
                            </div>
                          </div>

                          <div style="background-color: #ffc107; padding: 8px; text-align: center; font-size: 0.8em; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; color: #333;">www.eventos2025.com</div>
                      </div>

                      </body>
                    </html>');

  $conexao->close();

  $dompdf->setPaper('A4'); //tipo de papel
  $dompdf->render(); //renderizar 
  $dompdf->stream(); //download