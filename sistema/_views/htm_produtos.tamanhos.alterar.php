<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>alterar_tamanho_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Titulo</label>
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>">
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="codigo" value="<?=$data->codigo?>">
	
</form>