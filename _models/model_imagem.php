<?php

Class model_imagem extends model{
    
    public function codigo($codigo){
    	
    	$return = '';

		$db = new mysql();
		$exec = $db->executar("select * from imagem where codigo='$codigo' ");
		$data = $exec->fetch_object();

		if($data->imagem){
			$return = PASTA_CLIENTE.'imagens/'.$data->imagem;
		}
		
		return $return;
    }

}