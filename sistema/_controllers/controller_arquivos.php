<?php

class arquivos extends controller {
	
	protected $_modulo_nome = "Arquivos";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(67);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$arquivos = new model_arquivos();		
		$dados['lista'] = $arquivos->lista();		
		
		$this->view('arquivos', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base(); 
		$this->view('arquivos.novo', $dados);
	}

	public function novo_grv(){
		
		$titulo = $this->post('titulo');
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$this->valida($titulo);
		
		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		$arquivos = new model_arquivos();

		//// Definicao de Diretorios / 
		$diretorio = "arquivos/arquivos/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
				
				$nome_original = $_FILES['arquivo']['name'];
				$nome_arquivo  = $arquivo->trata_nome($nome_original);
				
				$destino = $diretorio.$nome_arquivo;
				
				if(copy($tmp_name, $destino)){
					
					$codigo = $this->gera_codigo();

					$arquivos->inserir(array(
						$codigo,
						$this->_cod_usuario,
						$titulo,
						$nome_arquivo
					));
					
					$this->irpara(DOMINIO.$this->_controller);
					
				} else {
					$this->msg('Não foi possível copiar o arquivo!');
					$this->volta(1);					
				}				
		}
		
	}	

	public function apagar_varios(){
		
		$arquivos = new model_arquivos();

		foreach ($arquivos->lista() as $key => $value) {
			
			if($this->post('apagar_'.$value['id']) == 1){

				unlink("arquivos/arquivos/".$value['arquivo']);
				// apaga
				$arquivos->apagar($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller);		
	}

}