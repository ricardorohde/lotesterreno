<?php

class cadastro_email extends controller {
	
	protected $_modulo_nome = "Cadastro de E-mails";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(70);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// intancia
		$cadastro = new model_cadastro_email();
		
		$dados['lista'] = $cadastro->lista();
		
		$this->view('cadastro.email', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Novo";

		$this->view('cadastro.email.novo', $dados);
	}

	public function novo_grv(){
		
		$nome = $this->post('nome');
		$email = $this->post('email');

		$this->valida($nome);
		$this->valida($email);

		$valida = new model_valida();
		if(!$valida->email($email)){
			$this->msg('Email inválido!');
			$this->volta(1);
		}

		// intancia
		$cadastro = new model_cadastro_email();

		if(!$cadastro->confere($email)){

			$this->msg('E-mail já cadastrado!');
			$this->volta(1);

		} else {

			$cadastro->adiciona(array(
				$nome,
				$email,
				"Cadastro manual"
			));
		 	
			$this->irpara(DOMINIO.$this->_controller);
		}
	}
	
	public function apagar_varios(){
		
		// intancia
		$cadastro = new model_cadastro_email();

		foreach ($cadastro->lista() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				$cadastro->apagar($value['id']);
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}

	public function importar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Importar";
		
		$this->view('cadastro.email.importar', $dados);
	}

	public function importar_lista(){
		
		$lista = $this->post('lista');
		$formato = $this->post('formato');
		
		if($formato == 1){
			$lista_array = explode(';', $lista);
		} else {
			$lista_array = explode(',', $lista);
		}

		// intancia
		$cadastro = new model_cadastro_email();
		$valida = new model_valida();

		$importados = 0;
		foreach ($lista_array as $key => $value) {
 		
 			if($value){
			if($cadastro->confere($value)){

				$cadastro->adiciona(array(
					"",
					$value,
					"Importado"
				));

				$importados++;
			}
			}
		}

		$this->msg($importados.' email(s) importado(s)');
 		
		$this->irpara(DOMINIO.$this->_controller);
	}

	public function exportar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Exportar";
		
		$dados['mostrar_lista'] = false;

		// intancia
		$cadastro = new model_cadastro_email();

		//grupos
		$dados['lista_grupos'] = $cadastro->lista_grupos(); 

		$formato = $this->post('formato');
		$grupo = $this->post('grupo');

		$dados['grupo'] = $grupo;
		$dados['formato'] = $formato;

		if($formato AND $grupo){

			$dados['mostrar_lista'] = true;

			if($formato == 1){
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';
			if($grupo == 'todos'){

				foreach ($cadastro->lista() as $key => $value) {				 
					$lista_exportada .= $value['email'].$separador;
				}

			} else {

				foreach ($cadastro->lista_interesse($grupo) as $key => $value) {		 
					$lista_exportada .= $value['email'].$separador;
				}

			}
			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.email.exportar', $dados);
	}


}