<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post" enctype="multipart/form-data" >
	
	<fieldset>
		
		<div class="form-group">
			<div class="col-md-12">
				<input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" disabled >
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-12">Ativar/desativar esta opção de pagamento</label>
			<div class="col-md-3">
				<select data-plugin-selectTwo class="form-control populate" name="ativo" >
					<option value='0' <?php if($data->ativo == 0){ echo "selected"; } ?> >Ativo</option>
					<option value='1' <?php if($data->ativo == 1){ echo "selected"; } ?> >Inativo</option>
				</select>
			</div>
		</div>

		<?php if($id == 1){ ?>

			<div class="form-group">
				<label class="col-md-12" >E-mail no Pagseguro</label>
				<div class="col-md-12">
					<input name="email_pagseguro" type="text" class="form-control" value="<?=$data->email_pagseguro?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Token de Retorno</label>
				<div class="col-md-12">
					<input name="token_retorno_pagseguro" type="text" class="form-control" value="<?=$data->token_retorno_pagseguro?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Endereço de Finalização da Compra</label>
				<div class="col-md-12">
					<?=$endereco_finalizacao?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Endereço do Retorno de Dados</label>
				<div class="col-md-12">
					<?=$endereco_retorno?>
				</div>
			</div>

		<?php } ?>


		<?php if( ($id == 2) OR ($id == 4) ){ ?>

			<div class="form-group">
				<label class="col-md-12" >Desconto de R$ (Valor Fixo)</label>
				<div class="col-md-12">
					<input name="desconto_fixo" type="text" class="form-control" value="<?=$desconto_fixo?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)"  >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-12" >Desconto de % (Porcentagem)</label>
				<div class="col-md-12">
					<input name="desconto_porc" type="text" class="form-control" value="<?=$desconto_porc?>" onkeypress="Mascara(this,porcentagem)" onKeyDown="Mascara(this,porcentagem)"  maxlength="5" >
				</div>
			</div>
			
		<?php } ?>

		<?php if($id == 2){ ?>
			
			<div class="form-group">
				<label class="col-md-12">Dados para Depósito</label>
				<div class="col-md-12">
					<textarea name="deposito_dados" rows="5" class="form-control" ><?=$data->deposito_dados?></textarea>
				</div>
			</div>

		<?php } ?> 

		<?php if($id == 4){ ?>

			<div class="form-group">
				<label class="col-md-12" >Client ID</label>
				<div class="col-md-12">
					<input name="gerencianet_clientId" type="text" class="form-control" value="<?=$data->gerencianet_clientId?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Client Secret</label>
				<div class="col-md-12">
					<input name="gerencianet_clientSecret" type="text" class="form-control" value="<?=$data->gerencianet_clientSecret?>" >
				</div>
			</div>

		<?php } ?>

		<?php if($id == 3){ ?>

			<div class="form-group">
				<label class="col-md-12" >Client Id </label>
				<div class="col-md-12">
					<input name="mercadopago_client_id" type="text" class="form-control" value="<?=$data->mercadopago_client_id?>" >
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-12" >Client Secret</label>
				<div class="col-md-12">
					<input name="mercadopago_client_secret" type="text" class="form-control" value="<?=$data->mercadopago_client_secret?>" >
				</div>
			</div>

		<?php } ?>

	</fieldset>

	<button type="submit" class="btn btn-primary">Salvar</button>
	<input type="hidden" name="id" value="<?=$data->id?>">

</form>