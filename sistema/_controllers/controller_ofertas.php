<?php

class ofertas extends controller {
	
	protected $_modulo_nome = "Ofertas";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(90);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		$ofertas = new model_ofertas();
		$dados['lista'] = $ofertas->lista();
		
		$this->view('ofertas', $dados);
	}

	public function nova(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova";

		$dados['aba_selecionada'] = "dados";

		$this->view('ofertas.nova', $dados);
	}

	public function nova_grv(){

		$arquivo = new model_arquivos_imagens();

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$validade = $this->post('validade');		
		$this->valida($validade);

		$arraydata = explode("/", $validade);
		$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 00:00";
		$data_final = strtotime($hora_montada);

		$diretorio = "arquivos/img_ofertas/";
		
		if(!$arquivo->filtro($arquivo_original)){
			$this->msg('Arquivo com formato inválido ou inexistente!');
			$this->volta(1);
		} else {

			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){
				
				$time = time();
				$codigo = $this->gera_codigo();

				$db = new mysql();
				$db->inserir("ofertas", array(
					"codigo"=>"$codigo",
					"data"=>"$time",
					"validade"=>"$data_final",
					"imagem"=>"$nome_arquivo"
				));

				$this->irpara(DOMINIO.$this->_controller);
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller.'/nova');
				
			}
		}		
	}
	
	public function apagar_varios(){

		$ofertas = new model_ofertas();

		foreach ($ofertas->lista() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				if($value['imagem']){
					unlink('arquivos/img_ofertas/'.$value['imagem']);
				}
				
				$conexao = new mysql();
				$conexao->apagar("ofertas", " id='".$value['id']."' ");		
			}
		}
		$this->irpara(DOMINIO.$this->_controller);
	}

}