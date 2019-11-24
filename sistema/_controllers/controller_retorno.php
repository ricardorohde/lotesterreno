<?php

class retorno extends controller {
	
	protected $_modulo_nome = "";
	
	public function init(){
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();		
		$this->volta(1);
	}
	
	public function pagseguro(){
		
		// retorno pagseguro
		$pagamentos = new model_formas_pagamento();
		$logs = new model_logs();
		$pedidos = new model_pedidos();
		
		$notificationCode = $this->post('notificationCode');
		$notificationType = $this->post('notificationType');
		
		$data_pagamentos = $pagamentos->carrega(1);
		$email_pagseguro = $data_pagamentos->email_pagseguro;
		$token_pagseguro = $data_pagamentos->token_retorno_pagseguro;
		
		//grava log de retorno
		$msg = "Comunicação $notificationType - $notificationCode ";
		$logs->gravar('pagseguro.txt', $msg);
		
		//teste
		//$notificationCode = "";
		
		$url = "https://ws.pagseguro.uol.com.br/v3/transactions/notifications/$notificationCode?email=$email_pagseguro&token=$token_pagseguro";		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$transaction= curl_exec($curl);
		if($transaction == 'Unauthorized'){
		   
			//grava log de retorno
			$msg = "Transasão não autorizada";
			$logs->gravar('pagseguro.txt', $msg);

		} else{
			
			curl_close($curl);
			$transaction = simplexml_load_string($transaction);
			
			$id_pedido = $transaction->reference;
			$status_pagseguro = $transaction->status;
			$valor_pagseguro = $transaction->netAmount;
			
			if($id_pedido){
				
				//grava log de retorno
				$msg = "Transasão $id_pedido Recebida, Status: $status_pagseguro";
				$logs->gravar('pagseguro.txt', $msg);
				
				//status que esta pago e aprovado pela operadora
				if($status_pagseguro == 3){
					$pedidos->altera_status($valor_pagseguro, 'PagSeguro', $status_pagseguro, $id_pedido);
				}

			} else {
				$msg = "Erro na leitura do pedido - $id_pedido";
				$logs->gravar('pagseguro.txt', $msg);
			}

		} 
	}
	
}