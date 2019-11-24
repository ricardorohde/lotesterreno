<?php

class cadastro_whats extends controller {
	
	protected $_modulo_nome = "Cadastro de Celular";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(91);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// intancia
		$cadastro = new model_cadastro_whats();
		
		$dados['lista'] = $cadastro->lista();
		
		$this->view('cadastro.whats', $dados);
	}
	
	public function apagar_varios(){
		
		// intancia
		$cadastro = new model_cadastro_whats();

		foreach ($cadastro->lista() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				$db = new mysql();
				$db->apagar("cadastro_celular", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}

	public function exportar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar";
		
		$dados['mostrar_lista'] = false;

		// intancia
		$cadastro = new model_cadastro_whats();
		$formato = $this->post('formato');
		$dados['formato'] = $formato;

		if($formato){

			$dados['mostrar_lista'] = true;

			if($formato == 1){
				$separador = ";\n";
			} else {
				if($formato == 2){
					$separador = ",\n";
				} else {
					$separador = "\n";
				}
			}
			
			$lista_exportada = '';
			foreach ($cadastro->lista() as $key => $value) {				 
				$lista_exportada .= $value['celular'].$separador;
			}
			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.whats.exportar', $dados);
	}

}