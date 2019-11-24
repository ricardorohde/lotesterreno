<?php

Class model_pedidos extends model{

	public function lista_incompletos(){

		$cadastro = new model_cadastros();
		
		$lista = array();
		$i = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='0' order by id desc"); 
		while($data = $exec->fetch_object()) { 
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['data'] = date('d/m/y H:i', $data->data);
			$lista[$i]['data_int'] = $data->data;

			if( $data->cadastro ){
				if($cadastro_data = $cadastro->carrega($data->cadastro)){
					$lista[$i]['email'] = $cadastro_data->email;
				} else {
					$lista[$i]['email'] = '';
				}
			} else {
				$lista[$i]['email'] = '';
			}
			
			$i++;
		}
		
		return $lista;
	}
	
	public function lista_aguardando(){
		
		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='1' OR status='2' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->valor_total);
				$lista[$i]['status'] = $this->status($data->status);
				$lista[$i]['email'] = $cadastro_data->email;

				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$i++;
			}
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_aprovados(){
		
		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();
		
		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='3' OR status='4' OR status='5' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){
				
				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->valor_total);
				$lista[$i]['status'] = $this->status($data->status);
				$lista[$i]['email'] = $cadastro_data->email;
				
				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$n_msg = $this->mensagens_n_lidas($data->codigo);
				if($n_msg != 0){
					$lista[$i]['msg'] = "$n_msg Mensagens não lidas.";
				} else {
					$lista[$i]['msg'] = "";
				}

				$i++;
			}
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_entregues(){

		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='6' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->valor_total);
				$lista[$i]['status'] = $this->status($data->status);
				$lista[$i]['email'] = $cadastro_data->email;

				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$n_msg = $this->mensagens_n_lidas($data->codigo);
				if($n_msg != 0){
					$lista[$i]['msg'] = "$n_msg Mensagens não lidas.";
				} else {
					$lista[$i]['msg'] = "";
				}

				$i++;
			}
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_cancelados(){

		// intancia
		$valores = new model_valores();
		$cadastro = new model_cadastros();

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where status='7' order by id asc");
		$i = 0;
		while($data = $exec->fetch_object()) { 

			$cadastro_data = $cadastro->carrega($data->cadastro);

			if( isset($cadastro_data->email) ){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['codigo'] = $data->codigo;
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['valor'] = $valores->trata_valor($data->valor_total);
				$lista[$i]['status'] = $this->status($data->status);
				$lista[$i]['email'] = $cadastro_data->email;

				if($cadastro_data->tipo == 'F'){
					$lista[$i]['nome'] = $cadastro_data->fisica_nome;
				} else {
					$lista[$i]['nome'] = $cadastro_data->juridica_nome;
				}

				$i++;
			}
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function mensagens_n_lidas($codigo){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja_mensagens WHERE pedido='$codigo' AND usuario!='1' AND lida='0' ");
		return $exec->num_rows;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function limpa_mensagens_n_lidas($codigo){

		$data = $this->carrega($codigo);

		$db = new mysql();
		$exec = $db->alterar("pedido_loja_mensagens", array(
			"lida"=>"1"
		), " pedido='$codigo' AND usuario!='1' AND lida='0' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_mensagens($pedido){

		$lista = array();
		$n = 0;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM pedido_loja_mensagens WHERE pedido='$pedido' order by data asc");
		while($data= $coisas->fetch_object()){

			$lista[$n]['id'] = $data->id;
			$lista[$n]['usuario'] = $data->usuario;
			$lista[$n]['data'] = date('d/m/y H:i', $data->data);			
			$lista[$n]['msg'] = $data->msg;

			if($data->anexo){
				$lista[$n]['anexo'] = PASTA_CLIENTE.'anexos_pedidos/'.$pedido.'/'.$data->anexo;
			} else {
				$lista[$n]['anexo'] = false;
			}

			$n++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function status($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja_status where codigo='$codigo' ");
		return $exec->fetch_object()->status;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja where codigo='$codigo' ");
		return $exec->fetch_object();
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_status($valor_pago, $forma_pagamento, $status, $id_pedido){

		$dados = array(
			"valor_pago"=>"$valor_pago",
			"forma_pagamento"=>"$forma_pagamento",
			"status"=>"$status"
		);
		// executa
		$db = new mysql();
		$db->alterar("pedido_loja", $dados, " codigo='".$id_pedido."' ");

	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_status($codigo = null){

		// intancia

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM pedido_loja_status order by codigo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {

			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['status'] = $data->status;

			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}

			$i++;
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function lista_carrinho($codigo){

		$valores = new model_valores();

		$lista = array();
		$i = 0;

		$conexao = new mysql();
		$coisas_carrinho = $conexao->Executar("SELECT * FROM pedido_loja_carrinho WHERE sessao='$codigo' ");
		$linha_carrinho = $coisas_carrinho->num_rows;

		if($linha_carrinho != 0){
			while($data_carrinho = $coisas_carrinho->fetch_object()){

				$produto_nome = "<div>$data_carrinho->produto_titulo</div>";

				if($data_carrinho->tamanho_titulo){ $produto_nome .= "<div>Tamanho: $data_carrinho->tamanho_titulo</div>"; }
				if($data_carrinho->cor_titulo){ $produto_nome .= "<div>Cor: $data_carrinho->cor_titulo</div>"; }
				if($data_carrinho->variacao_titulo){ $produto_nome .= "<div>Variação: $data_carrinho->variacao_titulo</div>"; }

				$lista[$i]['id'] = $data_carrinho->id;
				$lista[$i]['produto'] = $data_carrinho->produto;
				$lista[$i]['tamanho'] = $data_carrinho->tamanho;
				$lista[$i]['cor'] = $data_carrinho->cor;
				$lista[$i]['variacao'] = $data_carrinho->variacao;

				$lista[$i]['produto_nome'] = $produto_nome;
				$lista[$i]['quantidade'] = $data_carrinho->quantidade;
				$lista[$i]['valor_total'] = $data_carrinho->valor_total;
				$lista[$i]['valor_total_tratado'] = $valores->trata_valor($data_carrinho->valor_total);
				$lista[$i]['total_calculo'] = $data_carrinho->valor_total * $data_carrinho->quantidade;
				$lista[$i]['total_calculo_tratado'] = $valores->trata_valor($lista[$i]['total_calculo']);
				$lista[$i]['reserva_estoque'] = $data_carrinho->reserva_estoque;

				$i++;
			}
		}

		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_pedido($vars, $codigo){
		
		$cadastro = new model_cadastros();
		$produtos = new model_produtos();
		
		
		// carrega dados
		$data_pedido = $this->carrega($codigo);
		$data_cadastro = $cadastro->carrega($data_pedido->cadastro);


		// altera o estoque caso necessario
		if( ($data_pedido->status != 7) AND ($vars[2] == 7) ){

			// novo pedido cancelado			
			foreach ($this->lista_carrinho($codigo) as $key => $value) {
				
				// lista itens
				if($value['reserva_estoque'] == 1){

					$descricao = "Registro Automatico - Adicionado ".$value['quantidade']." item(s) - Cancelamento Pedido ".$data_pedido->id." ";

					// volta estoque
					$produtos->add_estoque_auto($value['produto'], $value['tamanho'], $value['cor'], $value['variacao'], $value['quantidade'], $descricao);

					// marca como processado
					$db = new mysql();
					$db->alterar("pedido_loja_carrinho", array(
						"reserva_estoque"=>"0"
					), " id='".$value['id']."' ");

				}
			}
		}

		
		// envia o email
		$envio = new model_envio();
		$retorno = $envio->enviar("Nova interação", "Nova interação no Pedido $data_pedido->id<br>Acesse sua área de cliente para visualizar.", array("0"=>"$data_cadastro->email"));
		
		
		// altera pedido
		$dados = array(
			"valor_pago"	=>$vars[0],
			"codigo_envio"	=>$vars[1],
			"status"		=>$vars[2]
		);
		$db = new mysql();
		$db->alterar("pedido_loja", $dados, " codigo='$codigo' ");

	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	
	public function reduz_estoque($codigo){

		$produtos = new model_produtos();

		foreach ($lista_carrinho as $key => $value) {

			$produto = $value['produto'];

			$tamanho = $value['tamanho'];
			if($tamanho == 0){ $tamanho = "-"; }

			$cor = $value['cor'];
			if($cor == 0){ $cor = "-"; }

			$variacao = $value['variacao'];
			if($variacao == 0){ $variacao = "-"; }

			$estoque_atual = $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);

			$novo_estoque = $estoque_atual - $value['quantidade'];
			if($novo_estoque < 0){ $novo_estoque = 0; }

			// atualiza o estoque
			$produtos->altera_estoque($produto, $tamanho, $cor, $variacao, $novo_estoque);

		}

	}

}