<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div style="text-align:center; padding-top:100px; font-size:15px; ">Você já tem as fotos?</div>

<div style="text-align:center; padding-top:20px; padding-bottom:100px;">
	
	<button type="button" class="btn btn-primary" onClick="window.location='<?=DOMINIO?>imoveis/novo_grv/fotos/1/cadastro/<?=$cod_cadastro?>';" >Sim, quero adicionar agora.</button>
	
	<button type="button" class="btn btn-default" onClick="window.location='<?=DOMINIO?>imoveis/novo_grv/fotos/2/cadastro/<?=$cod_cadastro?>';" >Não, vou adicionar mais tarde.</button>
	
</div>