<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div style="text-align:center; padding-top:100px; font-size:15px; ">Você já tem as imagens do seu produto?</div>

<div style="text-align:center; padding-top:20px; padding-bottom:100px;">
	
	<button type="button" class="btn btn-primary" onClick="window.location='<?=DOMINIO?>produtos/novo_produto/fotos/1';" >Sim, quero adicionar agora.</button>
	
	<button type="button" class="btn btn-default" onClick="window.location='<?=DOMINIO?>produtos/novo_produto/fotos/2';" >Não, vou adicionar mais tarde.</button>
	
</div>