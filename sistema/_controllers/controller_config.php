<?php

class config extends controller {
	
	protected $_modulo_nome = "Configurações";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(2);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
 		
 		if($this->nivel_acesso(52, false)){
			$dados['acesso_emails'] = true;
		} else {
			$dados['acesso_emails'] = false;
		}
		if($this->nivel_acesso(36, false)){
			$dados['acesso_meta'] = true;
		} else {
			$dados['acesso_meta'] = false;
		}
		if($this->nivel_acesso(37, false)){
			$dados['acesso_smtp'] = true;
		} else {
			$dados['acesso_smtp'] = false;
		}
		if($this->nivel_acesso(38, false)){
			$dados['acesso_logo'] = true;
		} else {
			$dados['acesso_logo'] = false;
		}
		$dados['acesso_mascara'] = true;
		

		if($this->get('aba')){
			$dados['aba_selecionada'] = $this->get('aba');
		} else {

			if($dados['acesso_mascara']){
				$dados['aba_selecionada'] = 'mascara';
			}
			if($dados['acesso_logo']){
				$dados['aba_selecionada'] = 'imagem';
			}
			if($dados['acesso_smtp']){
				$dados['aba_selecionada'] = 'smtp';
			}
			if($dados['acesso_meta']){
				$dados['aba_selecionada'] = 'meta';
			}
			if($dados['acesso_emails']){
				$dados['aba_selecionada'] = 'emails';
			}			 

		}

		$config = new model_config();
		$mascara = new model_mascara();
 		
 		$dados['data'] = $config->carrega_config();
		$dados['data_meta'] = $config->carrega_meta();

		//lista emails
		if($dados['acesso_emails']){
			
			$dados['contatos'] = $config->lista_contatos();

		}
		//lista mascara
		if($dados['acesso_mascara']){
			
			$dados['mascaras'] = $mascara->lista();

		}

		$this->view('config', $dados);
	}
	



	// CONTATOS

	public function novo_email(){

		$dados['_base'] = $this->base();

		$this->view('config.novo.email', $dados);
	}

	public function novo_email_grv(){
		
		$this->nivel_acesso(52);

		$titulo = $this->post('titulo');
		$email = $this->post('email');

		$this->valida($titulo);
		$this->valida($email);

		// instancia
		$config = new model_config();

		$codigo = $this->gera_codigo();

		$config->adiciona_contato(array(
			$codigo,
			$titulo,
			$email
		));		 

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/emails');
	}

	public function alterar_email(){

		$this->nivel_acesso(52);

		$dados['_base'] = $this->base();
		

		$id = $this->get('codigo');

		$this->valida($id);

		// instancia
		$config = new model_config();
 		
		$dados['data'] = $config->carrega_contato($id);

		$this->view('config.alterar.email', $dados);
	}	
	
	public function alterar_email_grv(){
		
		$this->nivel_acesso(52);

		$id = $this->post('id');
		$titulo = $this->post('titulo');
		$email = $this->post('email');

		$this->valida($titulo);
		$this->valida($email);
		$this->valida($id);

		// instancia
		$config = new model_config();

		$config->altera_contato(array(
			$titulo,
			$email
		), $id);

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/emails');
	}	

	public function apagar_emails(){

		$this->nivel_acesso(52);

		// instancia
		$config = new model_config();

		foreach ($config->lista_contatos() as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				$config->apagar_contato($value['id']);
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/emails');
	}



	// META

	public function meta_grv(){

		$this->nivel_acesso(36);

		// instancia
		$config = new model_config();

		$titulo_pagina = $this->post('titulo_pagina');
		$descricao = $this->post('descricao');

		$config->altera_meta(array(
			$titulo_pagina,
			$descricao
		));
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/meta');
	}

	public function smtp_grv(){

		$this->nivel_acesso(37);

		$email_nome = $this->post('email_nome');
		$email_origem = $this->post('email_origem');
		$email_retorno = $this->post('email_retorno');
		$email_porta = $this->post('email_porta');
		$email_host = $this->post('email_host');
		$email_usuario = $this->post('email_usuario');
		$email_senha = $this->post('email_senha');

		$this->valida($email_nome);
		$this->valida($email_origem);
		$this->valida($email_retorno);
		$this->valida($email_porta);
		$this->valida($email_host);
		$this->valida($email_usuario);
		$this->valida($email_senha);

		// instancia
		$config = new model_config();

		$config->altera_smtp(array(
			$email_nome,
			$email_origem,
			$email_retorno,
			$email_porta,
			$email_host,
			$email_usuario,
			$email_senha
		));

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/smtp');
	}

	public function apagar_logo(){

		$this->nivel_acesso(38);

		// instancia
		$config = new model_config();

		$data = $config->carrega_config();

		if($data->logo){
			unlink('arquivos/img_logo/'.$data->logo);
		}

		$config->altera_logo("");

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');
	}

	public function logo(){

		$this->nivel_acesso(38);

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		// instancia
		$config = new model_config();
		$arquivo = new model_arquivos_imagens();	

		//// Definicao de Diretorios / 
		$diretorio = "arquivos/img_logo/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {	
		 
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			$destino = $diretorio.$nome_arquivo;
				
			if(copy($tmp_name, $destino)){
				
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					// foto grande
					$largura_g = 500;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);
					
					//redimenciona
					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g, $diretorio.$nome_arquivo);					
				}

				$config->altera_logo($nome_arquivo);				
					
				$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/imagem');
					
			} else {					
				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);
			}
				
		}

	}



	// MASCARA

	public function nova_mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Nova Marca d'água";

		$this->view('config.mascara.nova', $dados);
	}

	public function nova_mascara_grv(){

		$titulo = $this->post('titulo');
		$posicao = $this->post('posicao');
		$preencher = $this->post('preencher');
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$this->valida($titulo);

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		$mascara = new model_mascara();

		//// Definicao de Diretorios / 
		$diretorio = "arquivos/img_mascaras/";		 
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			$nome_original = $_FILES['arquivo']['name'];
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			$destino = $diretorio.$nome_arquivo;
			
			if(copy($tmp_name, $destino)){

				$codigo = $this->gera_codigo();

				$mascara->adiciona(array(
					$codigo,
					$titulo,
					$nome_arquivo,
					$posicao,
					$preencher
				));
			 	
				$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');

			} else {
				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);
			}

		}
	}	

	public function alterar_mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar Marca d'água";

 		$codigo = $this->get('codigo');

 		$mascara = new model_mascara();
 		
		$dados['data'] = $mascara->carrega($codigo);

		$this->view('config.mascara.alterar', $dados);

	}

	public function alterar_mascara_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$posicao = $this->post('posicao');
		$preencher = $this->post('preencher');
		
		$this->valida($codigo);
		$this->valida($titulo);
		
		$mascara = new model_mascara();

		$mascara->altera(array(
			$titulo,
			$posicao,
			$preencher
		), $codigo);
	 	
		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');
	}

	public function apagar_mascara(){
		
		$mascara = new model_mascara();

		foreach ($mascara->lista() as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				unlink('arquivos/img_mascaras/'.$value['imagem_nome']);
				
				$mascara->apagar($value['codigo']);
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/inicial/aba/mascara');
	}
	
	
}