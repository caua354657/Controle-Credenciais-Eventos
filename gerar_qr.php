<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/gerar_qr.css">
</head>
<body>

<div class="container-qr">

<?php
    require("phpqrcode/qrlib.php");

    $pasta = "qrcodes/";
    
    if(!file_exists($pasta)) 
        mkdir($pasta);

    if(isset($_POST['id_pessoa'], $_POST['id_empresa'], $_POST['cpf'])) 
    {
        $qrText = "ID = ".$_POST['id_pessoa']. "\n" ."ID_Empresa = ".$_POST['id_empresa']. "\n" ."CPF = ".$_POST['cpf'];

        $arquivoQR = $pasta.'qr_pessoa_'.$_POST['id_pessoa'].'.png';

        QRcode::png($qrText, $arquivoQR, QR_ECLEVEL_L, 5);

        echo '<img src="'.$arquivoQR.'" width="300px" height="300px">';
    } 
    else 
        echo '<div class="alert alert-danger">
                <strong>Erro ao gerar QR Code.</strong>
              </div>';
?>

</div>

</body>
</html>