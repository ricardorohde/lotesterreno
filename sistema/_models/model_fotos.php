<?php

Class model_fotos extends model{

	public function lista($grupo = null){
		
		$lista = array();
		
		if($grupo){

			$conexao = new mysql();
			$exec = $conexao->Executar("SELECT * FROM fotos_ordem where grupo='$grupo' ORDER BY id desc limit 1");
			$data_ordem = $exec->fetch_object();

			if(isset($data_ordem->data)){

				$order = explode(',', $data_ordem->data);

				$n = 0;
				foreach($order as $key => $value){

					$conexao = new mysql();
					$coisas = $conexao->Executar("SELECT * FROM fotos WHERE id='$value' ");
					$data = $coisas->fetch_object();

					if(isset($data->titulo)){

						$lista[$n]['id'] = $data->id;
						$lista[$n]['codigo'] = $data->codigo;
						$lista[$n]['titulo'] = $data->titulo;

						$n++;
					}
				}
			}
		}
		
		//echo "<pre>"; print_r($lista); echo "<pre>"; exit;
		return $lista;
	}
	
    public function lista_grupos($selecionado = null){
		return $this->lista_grupo_filho(0, $selecionado);
	}
	
	private function lista_grupo_filho($id_pai, $selecionado = null){
		
		$lista = array();
		
		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM fotos_grupos_ordem where id_pai='$id_pai' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$n = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM fotos_grupos WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['selected'] = '';
					
					if($selecionado == $data->codigo){
						$lista[$n]['selected'] = "selected";
					}

					$lista[$n]['filhos'] = $this->lista_grupo_filho($data->id, $selecionado);
					
					$n++;
				}
			}
		}
	  	
		return $lista;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM

	public function carrega_mascara(){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM fotos_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo){

		$db = new mysql();
		$db->alterar("fotos_marcadagua", array(			 
			"codigo"	=>$codigo
		), " id='1' " );

	}

	

}