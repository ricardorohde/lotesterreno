<?php

Class model_cadastro_email extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "cadastro_email";

	///////////////////////////////////////////////////////////////////////////
	//

    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." order by email asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['nome'] = $data->nome;
			$lista[$i]['email'] = $data->email;
			$lista[$i]['interesse'] = $data->interesse;

		$i++;
		}
	  	
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

    public function lista_interesse($grupo){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." WHERE interesse='$grupo' order by email asc");
		$i = 0;
		while($data = $exec->fetch_object()) {			 
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['email'] = $data->email;

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
			'nome'=>$vars[0],
			'email'=>$vars[1],
			'interesse'=>$vars[2]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_principal, $dados);

	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar($id){
		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_principal, " id='".$id."' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function confere($email){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM ".$this->tab_principal." where email='$email' ");
		$linhas = $exec->num_rows;
		
		if($linhas == 0){
			return true;
		} else {
			return false;
		}

	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_grupos(){

		$lista_grupos = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT interesse FROM ".$this->tab_principal." ");
		$i = 0;
		while($data = $exec->fetch_object()) {			
			if(!in_array($data->interesse, $lista_grupos)){
				$lista_grupos[$i] = $data->interesse;
				$i++;
			}
		}

		return $lista_grupos;
	}

		
}