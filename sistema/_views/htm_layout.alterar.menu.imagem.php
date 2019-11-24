<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<?php

if(!$data->imagem){

	?>
	
	<form action="<?=$_base['objeto']?>alterar_menu_imagem1_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

		<fieldset>

			<div class="form-group">
				<label class="col-md-12" >Icone do menu</label>
				<div class="col-md-12">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file">
								<span class="fileupload-exists">Alterar</span>
								<span class="fileupload-new">Procurar arquivo</span>
								<input type="file" name="arquivo" />
							</span>
							<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
						</div>
					</div>
				</div>
			</div>		 

		</fieldset>

		<button type="submit" class="btn btn-primary">Salvar</button>
		<input type="hidden" name="codigo" value="<?=$data->codigo?>" >

	</form>

<?php } else { ?>
	
	<div style="text-align: left; ">
		<img src="<?=PASTA_CLIENTE?>imagens/<?=$data->imagem?>" style="max-width:100px;">
	</div>
	
	<div style="margin-top: 20px;">
		<button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>apagar_menu_imagem1/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
	</div>
	
<?php } ?>

<hr>

<?php

if(!$data->banner){

	?>

	<form action="<?=$_base['objeto']?>alterar_menu_imagem2_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

		<fieldset>

			<div class="form-group">
				<label class="col-md-12" >Banner do menu</label>
				<div class="col-md-12">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-default btn-file">
								<span class="fileupload-exists">Alterar</span>
								<span class="fileupload-new">Procurar arquivo</span>
								<input type="file" name="arquivo" />
							</span>
							<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remover</a>
						</div>
					</div>
				</div>
			</div>		 

		</fieldset>

		<button type="submit" class="btn btn-primary">Salvar</button>
		<input type="hidden" name="codigo" value="<?=$data->codigo?>" >

	</form>

<?php } else { ?>

	<div style="text-align: left; ">
		<img src="<?=PASTA_CLIENTE?>imagens/<?=$data->banner?>" style="max-width: 300px;">
	</div>

	<div style="margin-top: 20px;">
		<button type="button" class="btn btn-default" onClick="confirma('<?=$_base['objeto']?>apagar_menu_imagem2/codigo/<?=$data->codigo?>');" >Apagar Imagem</button>
	</div>

	<?php } ?>