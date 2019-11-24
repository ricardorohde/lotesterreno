<?php
class conteudo extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		$this->irpara(DOMINIO);
	}

	public function pag(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		/////////////////////////////////
		// banners
		$banners = new model_banners();
		$dados['banners'] = $banners->lista('147502866622777');
		
		/////////////////////////////////
		
	 	$paginas = new model_paginas();
	 	$dados['rodape1'] = $paginas->conteudo('154395237824151');
	 	$dados['rodape2'] = $paginas->conteudo('154395236868752');
	 	
	 	//////////////////////////////////////////

	 	$codigo_pag = $this->get('id');
 	
		$dados['pagina'] = $paginas->conteudo_url($codigo_pag);
		
		//carrega view e envia dados para a tela
		$this->view('conteudo', $dados);
	}

}