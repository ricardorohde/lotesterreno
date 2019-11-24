<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div id="rodape" >
	<div class="container" >

		<div class="row" >
			
			<div class="col-xs-12 col-sm-3 col-md-3">
				
				<div class="rodape_titulo" >Acesso Rápido</div>
				
				<div class="acesso_rapido">
					<?php

					foreach ($_base['menu_rodape'] as $key => $value) {

						$destino = $value['destino'];
						$modal = "";

						if($value['id'] == '2'){
							$destino = "#";
							$modal = " onclick=\"modal('".DOMINIO."faleconosco/cadastre');\" ";
						}
						if($value['id'] == '1'){
							$destino = "#";
							$modal = " onclick=\"modal('".DOMINIO."faleconosco');\" ";
						}

						echo "<div><a href='".$destino."' ".$modal." >".$value['titulo']."</a></div>";


					}

					?>
				</div>

			</div>

			<div class="col-xs-12 col-sm-3 col-md-3">
				
				<div class="rodape_titulo" >Endereço</div>
				
				<div class="rodape_endereco">
					
					<div><?=$_base['rodape_endereco1']?></div>
					<div><?=$_base['rodape_endereco2']?></div>
					<div><?=$_base['rodape_endereco3']?></div>
					
				</div>
				
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3">

				<div class="rodape_titulo" >Fale Conosco</div>
				
				<div class='rodape_telefone' style="font-size: 16px; line-height: 25px;">
					<span style="padding-right:5px;"><i class="fa fa-phone" aria-hidden="true"></i></span><?=$_base['rodape_telefone1']?><br> 
					<span style="padding-right:5px;"><i class="fa fa-whatsapp" aria-hidden="true"></i></span><?=$_base['rodape_telefone2']?>
				</div>
				
				<div class="facebook_titulo" style="padding-top: 15px;" >Curta Nossa Fanpage</div>
				
				<div class="facebook" >
					<a href="<?=$_base['facebook']?>" target="_blank" ><img src="<?=LAYOUT?>img/facebook.svg" ></a>
				</div>
				
			</div>

			<div class="col-xs-12 col-sm-3 col-md-3">			 

				<div class="rodape_titulo" >Receba Nossas Novidades</div>

				<div class="cadastro_email" >
					<form name="form_news" id="form_news" method="post" >

						<div><input name='nome' class="form-control" placeholder="Digite seu Nome" ></div>

						<div style="margin-top:10px;"><input name='email' class="form-control" placeholder="Digite seu E-mail" ></div>

						<div style="margin-top:10px;"><button class="btn btn-default botao" type="button" onClick="enviar_cadastro_email();" >Enviar</button></div>

					</form>
				</div>


			</div>
			
		</div>

		<div class="row" >
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				
				<div class="rodape_linha" ></div>
				
                <div class='copyright' ><?=date('Y')?> &copy Todos os direitos reservados.<a>DevAction</a></div>
				
			</div>

		</div>


	</div>
</div>