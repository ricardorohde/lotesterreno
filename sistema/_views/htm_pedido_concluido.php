<?php require_once('_system/bloqueia_view.php'); ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Obrigado - <?=$_base['titulo_pagina']?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>">

	<meta name="description" content="<?=$_base['descricao']?>" />
	<meta property="og:description" content="<?=$_base['descricao']?>">
	<meta name="author" content="NuvemServ.com.br">
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow">
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />
	
	<link href="<?=LAYOUT?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/prettyPhoto.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/price-range.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/animate.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/main.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/responsive.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/personalizado.css" rel="stylesheet"> 
    
	<?php include_once('htm_css.php'); ?>
	
</head>

<body>

<?php // carrega o arquivo txt com o codigo do analytcs
echo ANALYTICS; ?>

<?php include_once('htm_modal.php'); ?>

<?php include_once('htm_topo.php'); ?>

<section>

    <div class="container">

            <div class="row">

                <div class='col-xs-12 col-sm-1 col-md-1'></div>

                <div class='col-xs-12 col-sm-4 col-md-10'>

                    <div><?=$texto?></div>

                </div>

                <div class='col-xs-12 col-sm-1 col-md-1'></div>

            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-1 col-md-1">
                    <div style="padding-top:50px;"></div>
                </div>
            </div>
            
    </div>

     

</section>


<?php include_once('htm_newslatter.php'); ?>

<?php include_once('htm_rodape.php'); ?>

<script src="<?=LAYOUT?>js/jquery.js"></script>
<script src="<?=LAYOUT?>js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>js/jquery.scrollUp.min.js"></script>
<script src="<?=LAYOUT?>js/price-range.js"></script>
<script src="<?=LAYOUT?>js/jquery.prettyPhoto.js"></script>
<script src="<?=LAYOUT?>js/main.js"></script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>

<?php include_once('htm_facebook_lateral.php'); ?>