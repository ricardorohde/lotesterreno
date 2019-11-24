<?php

Class model_arquivos extends model{

	/////////////////////////////////////////////////////////////////////////////
	//

	private $tab_principal = "hospedararquivo";


	///////////////////////////////////////////////////////////////////////////
	//

	public function inserir($vars){
 		
 		// condições da base de dados
		$dados = array(
			'codigo'=>$vars[0],
			'usuario'=>$vars[1],
			'data'=>time(),
			'titulo'=>$vars[2],
			'arquivo'=>$vars[3]
		);	 

		// executa
		$db = new mysql();
		$db->inserir($this->tab_principal, $dados);
	} 
	 
	///////////////////////////////////////////////////////////////////////////
	//

	public function apagar($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_principal, " codigo='".$codigo."' ");

	}
	
	///////////////////////////////////////////////////////////////////////////
	//

    public function lista(){    	 

    	$usuarios = new model_usuarios();
    	
    	$lista = array();

    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['arquivo'] = $data->arquivo;
			$lista[$i]['data'] = date("d/m/Y H:i", $data->data);
			$lista[$i]['usuario'] = $usuarios->selecionar($data->usuario)->nome;
		
		$i++;
		}
	  	
		return $lista;
	} 

	///////////////////////////////////////////////////////////////////////////
	//

    public function selecionar($codigo){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_principal." where codigo='$codigo' ");
		return $exec->fetch_object();
    }
	
}