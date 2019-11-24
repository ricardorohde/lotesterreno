<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>alterar_menu_grv" class="form-horizontal" method="post">
	
	<fieldset>
		
		<div class="form-group">
			<label class="col-md-12" >Nome</label>
			<div class="col-md-12">
				<input name="nome" type="text" class="form-control" value="<?=$data->titulo?>">
			</div>
		</div>
				
		<?php if( ($data->id != 1) AND ($data->id != 2) ){ ?>
		<div class="form-group">
			<label class="col-md-12" >Destino</label>
			<div class="col-md-12">
				<input name="destino" type="text" class="form-control" value="<?=$data->endereco?>" >
			</div>
		</div>
		<?php } ?>

		<div class="form-group">
			<label class="col-md-12">Visibilidade</label>
			<div class="col-md-6">
				<select name="visivel" class="form-control select2" style="width: 100%;" >
					<option value="0" <?php if($data->visivel == 0){ echo " selected='' "; } ?> >Ativado</option>
					<option value="1" <?php if($data->visivel == 1){ echo " selected='' "; } ?> >Desativado</option>
				</select>
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>
	
	<?php if( ($data->id != 1) AND ($data->id != 2) ){ ?>
		<button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>apagar_menu/codigo/<?=$data->codigo?>');" >Apagar</button>
	<?php } ?>

	<input type="hidden" name="codigo" value="<?=$data->codigo?>" >

</form>
</section>

<script>

	$(document).ready(function() {

		$(".select2").select2();
		
	}); 

</script>