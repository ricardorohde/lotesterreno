<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >

	<fieldset>
		
		<div class="form-group">
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" disabled >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Nome para exibição</label>
			<div class="col-md-12">
				<input name="titulo_exibicao" type="text" class="form-control" value="<?=$data->titulo_exibicao?>" >
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-12">Ativar/desativar esta opção de frete</label>
			<div class="col-md-3">
				<select data-plugin-selectTwo class="form-control populate" name="ativo" >
					<option value='0' <?php if($data->ativo == 0){ echo "selected"; } ?> >Ativo</option>
					<option value='1' <?php if($data->ativo == 1){ echo "selected"; } ?> >Inativo</option>
				</select>
			</div>
		</div>
		
		<?php if( $data->id == 5 ){ ?>
			
			<div class="form-group">
				<label class="col-md-12">Cidade para Proximidades</label>
				<div class="col-md-12">
					<input name="proximidade_cidade" type="text" class="form-control" value="<?=$data->proximidade_cidade?>" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) ){ ?>

			<div class="form-group">
				<label class="col-md-12">Cep do Remetente</label>
				<div class="col-md-12">
					<input name="cep" type="text" class="form-control" value="<?=$data->cep?>" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id == 5) OR ($data->id == 6) ){ ?>

			<div class="form-group">
				<label class="col-md-12" >Acrescimo de valor fixo no valor do pedido</label>
				<div class="col-md-3">
					<input name="acrescimo_fixo" type="text" class="form-control" value="<?=$acrescimoFixo?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id == 5) OR ($data->id == 6) ){ ?>

			<div class="form-group">
				<label class="col-md-12" >Acrescimo (%) no valor do pedido</label>
				<div class="col-md-7">
					<input name="acrescimo_porc" type="text" class="form-control" value="<?=$data->acrescimo_porc?>" onkeypress="Mascara(this,porcentagem)" onKeyDown="Mascara(this,porcentagem)" >
				</div>
			</div>				 

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) OR ($data->id == 4) OR ($data->id == 5) OR ($data->id == 6) ){ ?>

			<div class="form-group">
				<label class="col-md-12">Frete gratis para compras acima de</label>
				<div class="col-md-3">
					<input name="gratis_acima_de" type="text" class="form-control" value="<?=$gratis_acima_de?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
				</div>
			</div>

		<?php } ?>

		<?php if( ($data->id == 1) OR ($data->id == 2) ){ ?>

			<hr>

			<table class="table table-bordered table-hover" >

				<thead>
					<tr>
						<th>Estado</th>
						<th>UF</th>
						<th>Tipo do Frete</th>
						<th>Valor Fixo R$</th>
					</tr>
				</thead>

				<tbody id="sortable_lista" >					 

					<?php

					foreach ($frete_estado as $key => $value) {

						if($value['tipo'] == 0){
							$check1 = 'checked';
							$check2 = '';
							$dest = "";
						} else {
							$check1 = '';
							$check2 = 'checked';
							$dest = " style=' border: 1px solid #666; ' ";
						}

						echo '
						<tr>
						<td>'.$value['titulo'].'</td>
						<td>'.$value['uf'].'</td>
						<td>
						<input type="radio" name="estado_tipo_'.$value['uf'].'" id="tipo_'.$value['uf'].'_a" value="0" '.$check1.' > 
						<label for="tipo_'.$value['uf'].'_a" >Normal</label><br>
						<input type="radio" name="estado_tipo_'.$value['uf'].'" id="tipo_'.$value['uf'].'_b" value="1" '.$check2.' > 
						<label for="tipo_'.$value['uf'].'_b" >Valor Fixo</label>
						</td>
						<td > 
						<input name="estado_fixo_'.$value['uf'].'" type="text" class="form-control" value="'.$value['valor'].'" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" '.$dest.' >
						</td>
						</tr>
						';

					}
					?>

				</tbody>
			</table>

		<?php } ?>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="id" value="<?=$data->id?>">

</form>