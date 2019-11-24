
<form action="<?=DOMINIO?>faleconosco/ligamos_enviar" method="post" name="form_ligamos" id="form_ligamos" >

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" >&times;</button>
		<h4 class="modal-title">Nós Ligamos Pra Você</h4>
	</div>

	<div class="modal-body">

		<div class='modal_texto' >Qual seu interesse?</div>
		<div class='modal_input_div'>
			<select class="selectpicker" name="interesse" data-live-search="true"  >
				<option value='' >Selecione</option>
				<option value='Comprar' >Comprar</option>
				<option value='Vender' >Vender</option>
				<option value='Alugar' >Alugar</option>
				<option value='Outro' >Outro</option>
			</select>
		</div>
		<hr>
		<div class='modal_texto' >Digite seu Nome:</div>
		<div class='modal_input_div'>
			<input name='nome' class='modal_input' style='width:75%;' >
		</div>

		<div class='modal_texto' >Digite seu E-mail:</div>
		<div class='modal_input_div'>
			<input name='email' class='modal_input' style='width:75%;' >
		</div>

		<div class='modal_texto' >Digite seu Telefone:</div>
		<div class='modal_input_div'>
			<input name='fone' class='modal_input' style='width:50%;' onKeyPress="Mascara(this,telefone)" onKeyDown="Mascara(this,telefone)" maxlength="15">
		</div>

		<div class='modal_texto' >Melhor Horário:</div>
		<div class='modal_input_div'>
			<input name='horario' class='modal_input' style='width:50%;' >
		</div>

	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-success" onClick="form_ligamos.submit();" >Enviar</button>
		<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	</div>

</form>

<script>
	$('.selectpicker').selectpicker();
</script>