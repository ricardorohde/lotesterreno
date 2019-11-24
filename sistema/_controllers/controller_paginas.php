<?php

class paginas extends controller {
	
	protected $_modulo_nome = "Páginas";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(29);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$paginas = new model_paginas();		 
		$dados['lista'] = $paginas->lista();
		
		$this->view('paginas', $dados);
	}
	
	public function novo(){ 
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('paginas.nova', $dados);
	}

	public function nova_grv(){		 

		$titulo = $this->post('titulo');
		$conteudo = $_POST['conteudo'];

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("paginas", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo",
			"url"=>"$codigo",
			"bloqueio"=>"0"
		));

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}
	
	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		$dados['aba_selecionada'] = "dados"; 		 

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM paginas where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$pag =  $string = str_replace("sistema/", "", DOMINIO);
		$dados['url_atual'] = $pag.'conteudo/pag/id/'.$dados['data']->url;
		
		$this->view('paginas.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$conteudo = $_POST['conteudo'];
		$url = $this->post('url');

		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM paginas where url='$url' AND codigo!='$codigo' ");

		if($exec->num_rows != 0){
			$this->msg('Esta url já esta sendo utilizada por outra página!');
			$this->volta(1);
			exit;
		}

		$this->valida($titulo);
		
		$db = new mysql();
		$db->alterar("paginas", array(
			"titulo"=>"$titulo",
			"conteudo"=>"$conteudo",
			"url"=>"$url"
		), " codigo='$codigo' ");
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM paginas ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){				
				
				if($data->bloqueio != 1){
					$conexao = new mysql();
					$conexao->apagar("paginas", " id='$data->id' ");
				}

			}
		}

		$this->irpara(DOMINIO.$this->_controller);		
	}

}