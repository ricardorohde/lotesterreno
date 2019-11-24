<?php

Class model_imagens extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "imagem";

	///////////////////////////////////////////////////////////////////////////
	//

    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {			 
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			$lista[$i]['imagem'] = $data->imagem;

			$i++;
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

	public function adiciona($vars){
 		
 		// condições da base de dados
		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_principal, $dados);

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_titulo($titulo, $codigo){

		$dados = array(
			'titulo'=>$titulo
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_principal, $dados, " codigo='".$codigo."' ");

	}

	///////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_imagem($imagem, $codigo){

		$dados = array(
			'imagem'=>$imagem
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_principal, $dados, " codigo='".$codigo."' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar($codigo){
		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_principal, " codigo='".$codigo."' ");
		
	}
		
}