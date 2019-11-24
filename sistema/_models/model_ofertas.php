<?php

Class model_ofertas extends model{
	
	public function lista(){
		
		$lista = array();
		$n = 0;
		
		$conexao = new mysql();
		$coisas = $conexao->executar("SELECT * FROM ofertas ORDER BY data desc"); 
		while($data = $coisas->fetch_object()){
			
			$lista[$n]['id'] = $data->id;
			$lista[$n]['codigo'] = $data->codigo;
			$lista[$n]['data'] = date('d/m/Y', $data->data);
			$lista[$n]['validade'] = date('d/m/Y', $data->validade);
			$lista[$n]['imagem'] = DOMINIO.'arquivos/img_ofertas/'.$data->imagem;
			
			$n++;
		}
		
		return $lista;
	}
}