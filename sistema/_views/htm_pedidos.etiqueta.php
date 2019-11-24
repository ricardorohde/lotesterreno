<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />

  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>font-awesome-4.6.2/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>css/css.css">

  <style>
  
  body {
    background: #FFF;
  }

  .info{
    font-size:16px;
    color:#000;
    margin-top:10px;
  }

</style>

</head>
<body onload="self.print();" style="width:700px;" >

  <h2 class="panel-title" style="font-size:18px; padding-bottom: 10px; padding-top: 20px;"><strong>DESTINATÁRIO</strong></h2>

  <?php if($data_cadastro->fisica_nome){ ?>
    <div class="infos"><strong><?=$data_cadastro->fisica_nome?></strong></div>
  <?php } ?>

  <?php if($data_cadastro->juridica_razao){ ?>
    <div class="infos"><strong><?=$data_cadastro->juridica_razao?></strong></div>
  <?php } ?>

  <div class="infos"><strong>Endereço:</strong> <?=$data_cadastro->endereco?>, <?=$data_cadastro->numero?> - <?=$data_cadastro->complemento?></div>

  <div class="infos"><strong>Bairro:</strong> <?=$data_cadastro->bairro?></div>

  <div class="infos"><strong>Cidade:</strong> <?=$data_cadastro->cidade?> - <?=$data_cadastro->estado?></div>

  <div class="infos"><strong>Cep:</strong> <?=$data_cadastro->cep?></div>

  <!-- jQuery 2.2.3 -->
  <script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
</body>
</html>