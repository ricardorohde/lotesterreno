<?php

class pedidos_processos extends controller {

	public function init(){
	}
	
	public function inicial(){
		exit;
	}
	public function confere(){
		
		$dados['_base'] = $this->base();
		
		// model
		$pedidos = new model_pedidos();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='1' order by data desc");		
		while($data = $exec->fetch_object()){ 

			$data_limite = strtotime("+2 days", $data->data);
			
			if( $data_limite < time() ){
				// cancela pedido
				
				echo 'ID '.$data->id.' -'.date('d/m/Y', $data->data).' < '.date('d/m/Y').'<br>';
				
				$pedidos->altera_pedido(array(
					'0',
					'',
					'7'
				), $data->codigo);
			}
		}
	}
	
}