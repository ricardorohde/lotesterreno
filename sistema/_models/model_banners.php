<?php

Class model_banners extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "banner";
	private $tab_grupos = "banner_grupo";
	private $tab_ordem = "banner_ordem";

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista($grupo){
    	
    	$lista = array();

		$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM ".$this->tab_ordem." WHERE codigo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();

		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data);

			$n = 0;
			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas = $conexao->Executar("SELECT * FROM ".$this->tab_principal." WHERE id='$value' ");
				$data = $coisas->fetch_object();
				
				if(isset($data->titulo)){
					
					$lista[$n]['id'] = $data->id;
					$lista[$n]['codigo'] = $data->codigo;
					$lista[$n]['titulo'] = $data->titulo;
					$lista[$n]['imagem'] = $data->imagem;			 
					
				$n++;
				}
			}
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where codigo='$codigo' ");
		return $exec->fetch_object();
    }

    ///////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_banner($vars){ 

		$db = new mysql();
		$db->inserir($this->tab_principal, array(
			'codigo'	=>$vars[0],
			'grupo'		=>$vars[1],
			'titulo'	=>$vars[2],
			'endereco'	=>$vars[3],
			'grupo_produtos'=>$vars[4]
		));
		$ultid = $db->ultimo_id();
		return $ultid;
	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_banner($vars, $codigo){ 

		$db = new mysql();
		$db->alterar($this->tab_principal, array(
			'titulo'	=>$vars[0],
			'endereco'	=>$vars[1],
			'grupo_produtos'=>$vars[2]
		), " codigo='$codigo' " );

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_imagem($imagem, $codigo){ 

		$db = new mysql();
		$db->alterar($this->tab_principal, array(
			'imagem'	=>$imagem
		), " codigo='$codigo' " );
		
	}

	///////////////////////////////////////////////////////////////////////////
	//	 
	
	public function apaga_banner($codigo){ 
		
		$db = new mysql();
		$db->apagar($this->tab_principal, " codigo='$codigo' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function ordem($grupo){ 
    	$conexao = new mysql();
		$exec = $conexao->Executar("SELECT * FROM ".$this->tab_ordem." WHERE codigo='$grupo' ORDER BY id desc limit 1");
		$data_ordem = $exec->fetch_object();
		if(isset($data_ordem->data)){
			return $data_ordem->data;
		} else {
			return "";
		}
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_ordem($ordem, $codigo){
		
		$db = new mysql();
		$db->apagar($this->tab_ordem, " codigo='$codigo' ");
 		
 		$db = new mysql();
		$db->inserir($this->tab_ordem, array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));

	}


	///////////////////////////////////////////////////////////////////////////
	// GRUPOS

	public function lista_grupos($grupo = null){
 		
 		$categorias = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_grupos." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$categorias[$i]['id'] = $data->id;
			$categorias[$i]['codigo'] = $data->codigo;
			$categorias[$i]['titulo'] = $data->titulo;
			$categorias[$i]['largura'] = $data->largura;
			$categorias[$i]['altura'] = $data->altura;

			if($grupo == $data->codigo){
				$categorias[$i]['selected'] = true;
			} else {
				$categorias[$i]['selected'] = false;
			}			
			if( ($i == 0) AND (!$grupo) ){
				$categorias[$i]['selected'] = true;
			}
			
		$i++;
		}
		return $categorias;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_grupo($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_grupos." where codigo='$codigo' ");
		return $exec->fetch_object();
    }
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_grupo($vars){

		$dados = array(
			'codigo'	=>	$vars[0],
			'titulo'	=>	$vars[1],
			'largura'	=>	$vars[2],
			'altura'	=>	$vars[3]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_grupos, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_grupo($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0],
			'largura'	=>$vars[1],
			'altura'	=>$vars[2]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_grupos, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_grupo($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_grupos, " codigo='$codigo' ");

	}	 
 
	
}