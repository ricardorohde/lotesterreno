<?php

class formas_pagamento extends controller {
	
	protected $_modulo_nome = "Formas de Pagamento";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(75);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		// instancia
		$pagamento = new model_formas_pagamento();
		
		$dados['lista'] = $pagamento->lista();
		
		$this->view('formas_pagamento', $dados);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();

		$id = $this->get('id');

 		// instancia
		$pagamento = new model_formas_pagamento();
		$valores = new model_valores();

		$dados['data'] = $pagamento->carrega($id);
		$dados['id'] = $id;
		$data = $dados['data'];
		
		if($id == 1){
			$dados['endereco_retorno'] = DOMINIO.'retorno/pagseguro/';
			$dados['endereco_finalizacao'] = str_replace("sistema/", "", DOMINIO).'pedido_concluido/pagseguro/';
		}

		$dados['desconto_porc'] = $data->desconto_porc;
		$dados['desconto_fixo'] = $valores->trata_valor($data->desconto_fixo);	
		
		$this->view('formas_pagamento.detalhes', $dados);
	}

	public function alterar_grv(){
		
		$pagamento = new model_formas_pagamento();
		$valores = new model_valores();

		$id = $this->post('id'); 
		$ativo = $this->post('ativo');
		$email_pagseguro = $this->post('email_pagseguro');
		$token_retorno_pagseguro = $this->post('token_retorno_pagseguro');

		$desconto_fixo = $this->post('desconto_fixo');
		$desconto_fixo = $valores->trata_valor_banco($desconto_fixo);		
		$desconto_porc = $this->post('desconto_porc');

		$deposito_dados = $this->post('deposito_dados');

		$ativo = $this->post('ativo');
		$mercadopago_client_id = $this->post('mercadopago_client_id');
		$mercadopago_client_secret = $this->post('mercadopago_client_secret');

		$gerencianet_clientId = $this->post('gerencianet_clientId');
		$gerencianet_clientSecret = $this->post('gerencianet_clientSecret');
 		
		// executa
		$db = new mysql();
		$db->alterar("pagamento", array(
			"desconto_fixo"=>$desconto_fixo,
			"desconto_porc"=>$desconto_porc,
			"ativo"=>$ativo,
			"email_pagseguro"=>$email_pagseguro,
			"token_retorno_pagseguro"=>$token_retorno_pagseguro,
			"mercadopago_client_id"=>$mercadopago_client_id,
			"mercadopago_client_secret"=>$mercadopago_client_secret,
			"deposito_dados"=>"$deposito_dados",
			"gerencianet_clientId"=>$gerencianet_clientId,
			"gerencianet_clientSecret"=>$gerencianet_clientSecret
		), " id='$id' ");

		$this->irpara(DOMINIO.$this->_controller);		
	}

}