<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>cidades_alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Cidade</label>
			<div class="col-md-12">
				<input name="cidade" type="text" class="form-control" value="<?=$data->cidade?>" >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Estado (UF)</label>
			<div class="col-md-12">
				<input name="estado" type="text" class="form-control" value="<?=$data->estado?>" >
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="codigo" value="<?=$data->codigo?>">

</form>