<form action="<?=DOMINIO?>faleconosco/contato_enviar" method="post" name="form_contato" id="form_contato" >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" >&times;</button>
		<h4 class="modal-title">Fale Conosco</h4>
	</div>

	<div class="modal-body">	 

		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12">

				<div class='modal_texto' >Nome:</div>
				<div class='modal_input_div'>
					<input name='nome' class='modal_input' style='width:100%;' >
				</div>

			</div>      

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >Telefone.</div>
				<div class='modal_input_div'>
					<input name='fone' class='modal_input' style='width:100%;' onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15">
				</div>

			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">

				<div class='modal_texto' >E-mail.</div>
				<div class='modal_input_div'>
					<input name='email' class='modal_input' style='width:100%;' >
				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-xs-12 col-sm-12 col-md-12">

				<div class='modal_texto' >Digite sua mensagem.</div>
				<div class='modal_input_div'>
					<textarea name='msg' class='modal_input' style='width:100%; height:100px;' ></textarea>
				</div>

			</div>

		</div>


	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-success" onClick="form_contato.submit();" >Enviar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	</div>

</form>

<script>
	$('.selectpicker').selectpicker();
</script>