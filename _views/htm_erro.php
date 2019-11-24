<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Erro - <?=$_base['titulo_pagina']?></title>
    <link rel="shortcut icon" href="<?=$_base['favicon'];?>">

    <meta name="description" content="<?=$_base['descricao']?>" />
    <meta property="og:description" content="<?=$_base['descricao']?>">
    <meta name="author" content="mrcomerciodigital.site">
    <meta name="classification" content="Website" />
    <meta name="robots" content="index, follow">
    <meta name="Indentifier-URL" content="<?=DOMINIO?>" />
    
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/font-awesome-4.6.2/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/animate/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-select/dist/css/bootstrap-select.css">
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-slider-master/dist/css/bootstrap-slider.css">
    <link rel="stylesheet" href="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,900,700,300,300italic,400italic,500,500italic,700italic,900italic' rel='stylesheet' type='text/css'>    

    <?php include_once('htm_css.php'); ?>
    <?php include_once('htm_css_resp.php'); ?>

</head>
<body>

	<?=ANALYTICS?>

    <?php include_once('htm_modal.php'); ?>
    
    <?php include_once('htm_topo.php'); ?>
    
    <div id="conteudo_pagina2" class="conteudo_pagina2" >

        <div style="margin-top:200px; margin-bottom:200px; text-align: center; font-size: 20px; font-weight: 500;">Página não encontrada!</div> 

        <?php include_once('htm_subrodape.php'); ?>

        <?php include_once('htm_rodape.php'); ?>

    </div>

    <script src="<?=LAYOUT?>api/jquery/jquery-1.12.3.min.js"></script>
    <script src="<?=LAYOUT?>api/bootstrap/bootstrap.min.js"></script> 
    <script src="<?=LAYOUT?>api/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?=LAYOUT?>api/bootstrap-slider-master/dist/bootstrap-slider.min.js"></script>
    <script src="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
    <script src="<?=LAYOUT?>api/js_mascaras/mascaras.js"></script>
    <script src="<?=LAYOUT?>js/geral.js"></script>
    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    
</body>
</html>

<?php include_once('htm_chat.php'); ?>