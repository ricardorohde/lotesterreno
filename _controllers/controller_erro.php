<?php
class erro extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
			 	
		//carrega view e envia dados para a tela
		$this->view('erro', $dados);
	}

}