<?php
class index extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		/////////////////////////////////
		// banners
		$banners = new model_banners();
		$dados['banner_principal'] = $banners->lista('147502866622777');
		
		/////////////////////////////////
		// padroes
		$dados['url_referencia'] = "";
		$dados['url_categoria'] = "alugar";
		$dados['url_tipo'] = "tipo";
		$dados['url_cidade'] = CIDADE;
		$dados['url_bairro'] = "";
		$dados['url_dormitorios'] = "";
		$dados['url_suites'] = "";
		$dados['url_valor_maximo'] = "maximo";
		$dados['url_valor_minimo'] = "minimo";
		$dados['url_ordem'] = 0;
		
		$imoveis = new model_imoveis();
		$dados['tipos'] = $imoveis->tipos();
		$dados['cidades'] = $imoveis->cidades();
		
		// imoveis em destaque
		$dados['lista_locacao'] = $imoveis->destaques('locacao');
		$dados['lista_venda'] = $imoveis->destaques('venda');
		
		$db = new mysql();
		$exec = $db->executar("SELECT id FROM imoveis WHERE add_ok='1' AND categoria_id='5279' ");
		$dados['total_venda'] = $exec->num_rows;

		$db = new mysql();
		$exec = $db->executar("SELECT id FROM imoveis WHERE add_ok='1' AND categoria_id='5280' ");
		$dados['total_locacao'] = $exec->num_rows;
		
		//carrega view e envia dados para a tela
		$this->view('index', $dados);
	}

}