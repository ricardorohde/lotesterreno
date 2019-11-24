<form action="<?=DOMINIO?>faleconosco/cadastre_enviar" method="post" name="form_cadastre" id="form_cadastre" >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" >&times;</button>
		<h4 class="modal-title">Cadastre seu imóvel</h4>
	</div>

	<div class="modal-body">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class='modal_texto' style="padding-bottom:10px;">Você tem um imóvel que deseja agenciar conosco?<br>Então preencha os dados abaixo que em breve entraremos em contato.</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Nome:</div>
				<div class='modal_input_div'>
					<input name='nome' class='modal_input' style='width:100%;' >
				</div>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >E-mail:</div>
				<div class='modal_input_div'>
					<input name='email' class='modal_input' style='width:100%;' >
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Telefone:</div>
				<div class='modal_input_div'>
					<input name='fone' class='modal_input' style='width:100%;' onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15">
				</div>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Celular:</div>
				<div class='modal_input_div'>
					<input name='celular' class='modal_input' style='width:100%;' onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15">
				</div>

			</div>
		</div>


		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Cidade/UF:</div>
				<div class='modal_input_div'>
					<input name='cidade' class='modal_input' style='width:100%;' >
				</div>

			</div>

			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Bairro:</div>
				<div class='modal_input_div'>
					<input name='bairro' class='modal_input' style='width:100%;' >
				</div>

			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">

				<div class='modal_texto' >Descrição do imóvel:</div>
				<div class='modal_input_div'>
					<textarea name='descricao' class='modal_input' style='width:100%; height:100px;' ></textarea>
				</div>

			</div>
		</div>

	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-success" onClick="form_cadastre.submit();" >Enviar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	</div>
	
</form>