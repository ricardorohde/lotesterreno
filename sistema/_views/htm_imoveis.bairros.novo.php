<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>bairros_novo_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>

		<div class="form-group">
			<label class="col-md-12">Cidade</label>
			<div class="col-md-6">
				<select class="form-control select2" name="cidade" >
					<option value="0" selected >Selecione</option>
					<?php

					foreach ($cidades as $key => $value) {

						if($value['selected']){
							$selected = " selected='' ";
						} else {
							$selected = "";
						}

						echo "<option value='".$value['codigo']."' $selected >".$value['cidade']." - ".$value['estado']."</option>";

					}

					?>                        
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12" >Bairro</label>
			<div class="col-md-12">
				<input name="bairro" type="text" class="form-control" >
			</div>
		</div>
		
	</fieldset>
	
	<button type="submit" class="btn btn-primary">Salvar</button>

</form>