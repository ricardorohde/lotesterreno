<?php

Class model_config extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "adm_config";
	private $tab_meta = "meta";
	private $tab_contatos = "contato";

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_config(){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where id='1' ");
		return $exec->fetch_object();
    }

    ///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_meta(){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_meta." where id='1' ");
		return $exec->fetch_object();
    }

    ///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_contato($id){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_contatos." where id='$id' ");
		return $exec->fetch_object();
    }

	///////////////////////////////////////////////////////////////////////////
	//

    public function lista_contatos(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_contatos." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
		
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['email'] = $data->email;
			$lista[$i]['titulo'] = $data->titulo;
			
		$i++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_contato($vars){ 

		// executa
		$db = new mysql();
		$db->inserir($this->tab_contatos, array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1],
			'email'=>$vars[2]
		));
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_contato($vars, $id){

		$dados = array(
			'titulo'=>$vars[0],
			'email'=>$vars[1]
		);

		// executa
		$db = new mysql();
		$db->alterar($this->tab_contatos, $dados, " id='".$id."' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar_contato($id){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_contatos, " id='".$id."' ");

	}
	
  
	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_meta($vars){

		$dados = array(
			'titulo_pagina'=>$vars[0],
			'descricao'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_meta, $dados, " id='1' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_smtp($vars){

		$dados = array(
			'email_nome'	=>$vars[0],
			'email_origem'	=>$vars[1],
			'email_retorno'	=>$vars[2],
			'email_porta'	=>$vars[3],
			'email_host'	=>$vars[4],
			'email_usuario'	=>$vars[5],
			'email_senha'	=>$vars[6]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_principal, $dados, " id='1' ");
		
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_logo($imagem){
		
		// executa
		$db = new mysql();
		$db->alterar($this->tab_principal, array(
			'logo'	=>$imagem
		), " id='1' ");
		
	}
	


 
}