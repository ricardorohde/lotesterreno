<?php

Class model_paginas extends model{
	
    public function lista(){
    	
    	$lista = array();
    	
		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM paginas ORDER BY titulo asc");
		$n = 0;
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['titulo'] = $data->titulo;
			$lista[$n]['url'] = 'conteudo/pag/id/'.$data->url;
			$lista[$n]['bloqueio'] = $data->bloqueio;
			
		$n++;
		}
	  	
		return $lista;
	}
	
}