<?php

Class model_formas_pagamento extends model{
 		
    public function lista(){
    	
    	$lista = array();
    	
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM pagamento order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['titulo'] = $data->titulo;
			
		$i++;
		}
	  	
		return $lista;
	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega($id){
    	$db = new mysql();
		$exec = $db->executar("SELECT * FROM pagamento where id='$id' ");
		return $exec->fetch_object();
    }
	
}