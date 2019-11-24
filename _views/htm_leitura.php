<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?=$data->titulo?> - <?=$_base['titulo_pagina']?></title>
	<link rel="shortcut icon" href="<?=LAYOUT?>img/favicon.png">

	<meta name="description" content="<?=$data->previa?>" />
	<meta property="og:description" content="<?=$data->previa?>">
	<meta name="author" content="mrcomerciodigital.site">
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow">
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />

	<!--start Facebook Open Graph Protocol-->
	<meta property="og:site_name" content="<?=$_base['titulo_pagina']?>" />
	<meta property="og:title" content="<?=$data->titulo?> - <?=$_base['titulo_pagina']?>" />
	<meta property="og:url" content="<?=$endereco_postagem?>"/>
	<meta property="og:image" content="<?=$imagem_principal?>" />
	<link href="<?=$imagem_principal?>" rel="image_src" />
	<!--end Facebook Open Graph Protocol-->

	<link rel="stylesheet" href="<?=LAYOUT?>css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=LAYOUT?>api/font-awesome-4.6.2/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700|Open+Sans:300,400,600,700|Roboto:300,400,500,700" rel="stylesheet">
	
	<link rel="stylesheet" href="<?=LAYOUT?>css/css.css" rel="stylesheet"> 
	
	<?php
	include_once('_css.php');
	include_once('_css_responsivo.php');
	?>

</head>
<body>

	<?=ANALYTICS?>
	
	<?php include_once('htm_modal.php'); ?>

	<?php include_once('htm_topo.php'); ?>

	<div class="corpo" >
		
		<div class="menu_responsivo" ><a href="#corpo" class="botao_padrao" onClick="abre_menu();" >MENU</a></div>
		
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-4" >
					<div id="lateral" class="divisao_lateral" >
						<?php include_once('htm_lateral.php'); ?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-8" >

					<h2 class='lista_titulo' style="text-align: left;" >
						<a href='#' ><?=$data->titulo?></a>
					</h2>

					<div class="lista_data" style="text-align: left; margin-top: 10px;" ><i class='fa fa-aw fa-calendar-o' ></i> <?=date('d/m/Y', $data->data)?></div>
					
					<div class="conteudo" >
						<?=$data->conteudo?>
					</div>

					<hr>

					<?php

					if($data->link1){
						echo "
						<div class='baixar' >
						Download Opção 1<br>
						<a href='".$data->link1."' target='_blank'><img src='".LAYOUT."img/baixar1.jpg'></a>
						";

						if($data->legenda1){
							echo "
							<div class='legenda' >
							<a href='".$data->legenda1."' target='_blank'>Legenda Aqui</a>
							</div>
							";
						}

						echo "
						</div>
						";
					}



					if($data->link2){
						echo "
						<div class='baixar' >
						Download Opção 2<br>
						<a href='".$data->link2."' target='_blank'><img src='".LAYOUT."img/baixar1.jpg'></a>
						";

						if($data->legenda2){
							echo "
							<div class='legenda' >
							<a href='".$data->legenda2."' target='_blank'>Legenda Aqui</a>
							</div>
							";
						}

						echo "
						</div>
						";
					}

					if($data->link3){
						echo "
						<div class='baixar' >
						Download Opção 3<br>
						<a href='".$data->link3."' target='_blank'><img src='".LAYOUT."img/baixar1.jpg'></a>
						";

						if($data->legenda3){
							echo "
							<div class='legenda' >
							<a href='".$data->legenda3."' target='_blank'>Legenda Aqui</a>
							</div>
							";
						}

						echo "
						</div>
						";
					}

					?>

					<div style="margin-top:30px; padding-bottom:10px;">
						<hr>
					</div>

					<?php

					foreach ($imagens as $key => $value) {

						echo "<div class='imagem_interna' ><img src='".$value['imagem_g']."' ></div>";
						if($value['legenda']){
							echo "<div class='legenda' >".$value['legenda']."</div>";
						}

					}

					?>

					<div class="social" >

						<h3>Gostou? Compartilhe!</h3>

						<ul>
							<li>
								<a href="http://www.facebook.com/sharer.php?u=<?=$endereco_postagem?>" class="facebook" target="_blank" title="Compartilhar via Facebook"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="http://twitter.com/intent/tweet?text=<?=$data->titulo?>&url=<?=$endereco_postagem?>" class="twitter" target="_blank" title="Compartilhar via Twitter"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="https://plus.google.com/share?url=<?=$endereco_postagem?>" target="_blank" class="googleplus" title="Compartilhar via Google+"><i class="fa fa-google-plus"></i></a>
							</li>
							<li>
								<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?=$endereco_postagem?>" target="_blank" class="linkedin" title="Compartilhar via LinkedIn"><i class="fa fa-linkedin"></i></a>
							</li>
							<li>
								<a href="whatsapp://send?text=<?=$endereco_postagem?>" target="_blank" class="whatsapp" title="Compartilhar via Whatsapp" style="font-size: 19px;"><i class="fa fa-whatsapp"></i></a>
							</li>
						</ul>

					</div>


					<div>
						<a href="https://go.hotmart.com/Q10298775G?ap=9f93" target="_blank">
							<img src="<?=LAYOUT?>banners/cachaca.png" style="width:100%;">
						</a>
					</div>


					<div style="margin-bottom:100px; text-align: center;">
						<a class="dow-btn botao_padrao hvr-float-shadow" href="#" onClick="history.go(-1)" >Voltar</a>
					</div>

					<div style="clear:left;" ></div>				 




				</div>

			</div>		
		</div>
	</div>

	<?php include_once('htm_rodape.php'); ?>

	<script src="<?=LAYOUT?>js/jquery-3.3.1.min.js" type="text/javascript" ></script>
	<script src="<?=LAYOUT?>js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>api/jquery.scrollUp/jquery.scrollUp.min.js"></script>
	<script src="<?=LAYOUT?>js/geral.js"></script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	
	<script type="text/javascript">
		function abre_menu(){
			$('#lateral').toggle();
		}
	</script>

</body>
</html>