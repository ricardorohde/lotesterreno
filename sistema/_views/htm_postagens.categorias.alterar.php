<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<title><?=$_titulo?> - <?=TITULO_VIEW?></title>
	<link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
	
	<link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>font-awesome-4.6.2/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?=LAYOUT?>css/css.css">

</head>
<body class="hold-transition skin-blue <?php if($_base['menu_fechado'] == 1){ echo "sidebar-collapse"; } ?> sidebar-mini">
	<div class="wrapper">

		<?php require_once('htm_topo.php'); ?>

		<?php require_once('htm_menu.php'); ?>

		<div class="content-wrapper">

			<section class="content-header">
				<h1>
					<?=$_titulo?>
					<small><?=$_subtitulo?></small>
				</h1> 
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="row">
					
					<div class="col-xs-12">
						



						<section class="panel">
							<form action="<?=$_base['objeto']?>alterar_grupo_grv" class="form-horizontal" method="post">
								
								<div class="panel-body">
									
									<fieldset>
										
										<div class="form-group">
											<label class="col-md-12" >Titulo</label>
											<div class="col-md-6">
												<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
											</div>
										</div>
										
									</fieldset>
									
								</div>
								
								<div class="panel-footer">
									<div class="row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary">Salvar</button>
											<input type="hidden" name="codigo" value="<?=$data->codigo?>">
											<button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>grupos';">Voltar</button>
										</div>
									</div>
								</div>
								
							</form>
						</section>



					</div>

				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->

		</div>
		<!-- /.content-wrapper -->
		<?php require_once('htm_rodape.php'); ?>

	</div>
	<!-- ./wrapper -->

	<!-- jQuery 2.2.3 -->
	<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
	<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
	<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
	<script src="<?=LAYOUT?>dist/js/demo.js"></script>
	<script>
		$(function () {
			$('#tabela1').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true
			});
		});
	</script>
	<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
	<script src="<?=LAYOUT?>js/funcoes.js"></script>

</body>
</html>