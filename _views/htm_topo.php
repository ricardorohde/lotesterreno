<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<div id="topo" >
	
	<div id="menu_responsivo_botao" >
		<i class="fa fa-bars" aria-hidden="true"></i>
	</div>
	
	<div id="menu_fundo" ></div>
	
	<div style="position:absolute: width:100%; left:0px; top:0px;  ">
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-3 col-md-3">
					
					<div class="logo" style="margin-top: 10px;" >
						<a href="<?=DOMINIO?>" ><img src="<?=$_base['logo']?>" style="max-height:100px" ></a>
					</div>
					
				</div>
				<div class="col-xs-12 col-sm-9 col-md-9">
					
					<div class="topo_menu_cima" >
						
						<div class="topo_info" ><span class="topo_icones" ><i class="fa fa-phone" aria-hidden="true"></i></span> <?=$_base['topo_fone']?></div>
						
						<div class="topo_info" ><span class="topo_icones" ><i class="fa fa-user" aria-hidden="true"></i></span> <a href="#" onclick="modal('<?=DOMINIO?>faleconosco/ligamos');"  >Nós ligamos pra você</a></div>
						
					</div>
					
					<div id="menu" >
						
						<ul>
							<?php

							foreach ($_base['menu'] as $key => $value) {

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

								echo "<li><a href='".$destino."' ".$modal." >".$value['titulo']."</a></li>";
								
							}

							?>
							
						</ul>
						
					</div>
					
				</div>
				
			</div>
		</div>
	</div>

</div>

<div id="menu_responsivo" >
	
	<ul>
		<?php

		foreach ($_base['menu'] as $key => $value) {

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

			echo "<li><a href='".$destino."' ".$modal." >".$value['titulo']."</a></li>";

		}

		?>
	</ul>
	
</div>