<?php
class institucional extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		$paginas = new model_paginas();
		$dados['conteudo'] = $paginas->conteudo('154945815141516');
		
		//carrega view e envia dados para a tela
		$this->view('institucional', $dados);
	}

}