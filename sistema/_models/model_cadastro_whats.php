<?php

Class model_cadastro_whats extends model{

    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM cadastro_celular order by celular asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['celular'] = $data->celular;
			
		$i++;
		}
	  	
		return $lista;
	}
		
}