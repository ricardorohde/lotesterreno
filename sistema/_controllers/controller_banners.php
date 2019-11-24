<?php

class banners extends controller {
	
	protected $_modulo_nome = "Banners";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(44);
	}

	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// Instancia
		$banners = new model_banners();

		$grupo = $this->get('grupo');
		
		$dados['categorias'] = $banners->lista_grupos($grupo);
 		
 		if(!$grupo){
 			$grupo = $dados['categorias'][0]['codigo'];
 		}
		$dados['grupo'] = $grupo;
		$dados['grupo_nome'] = $banners->carrega_grupo($grupo)->titulo;
		$dados['lista'] = $banners->lista($grupo);		
		
		$this->view('banners', $dados);
	}	

	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Novo";

 		$dados['aba_selecionada'] = "dados"; 	 	 
 		
 		// Instancia
		$banners = new model_banners();

		$grupo = $this->get('grupo');
		$dados['grupo'] = $grupo;
		$dados['categorias'] = $banners->lista_grupos($grupo);

		// carrega categorias para vinculo
		$produtos = new model_produtos();
		$dados['categorias_produtos'] = $produtos->lista_categorias();

		$this->view('banners.novo', $dados);
	}

	public function nova_grv(){
		
		$titulo = $this->post('titulo');
		$categoria = $this->post('grupo');
		$grupo_produtos = $this->post('grupo_produtos');
		$endereco = $_POST['endereco'];

		$this->valida($titulo);
		$this->valida($categoria);
		
		// Instancia
		$banners = new model_banners();

		$codigo = $this->gera_codigo();

		$ultid = $banners->adiciona_banner(array(
			$codigo,
			$categoria,
			$titulo,
			$endereco,
			$grupo_produtos
		));
		
		$ordem = $banners->ordem($categoria);

		if($ordem){
			$novaordem = $ordem.",".$ultid;
		} else {
			$novaordem = $ultid;
		}
		$banners->altera_ordem($novaordem, $categoria);

		$this->irpara(DOMINIO.$this->_controller.'/alterar/aba/imagem/codigo/'.$codigo);
	}	

	public function alterar(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar";

 		$codigo = $this->get('codigo');

 		$aba = $this->get('aba');
 		if($aba){
 			$dados['aba_selecionada'] = $aba;
 		} else {
 			$dados['aba_selecionada'] = 'dados';
 		}
 		
 		// Instancia
		$banners = new model_banners(); 		
		
		$dados['data'] = $banners->carrega($codigo);
		
		$dados['categorias'] = $banners->lista_grupos($dados['data']->grupo);
		
		// carrega categorias para vinculo
		$produtos = new model_produtos();
		$dados['categorias_produtos'] = $produtos->lista_categorias();
		
		$this->view('banners.alterar', $dados);
	}

	public function alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$grupo_produtos = $this->post('grupo_produtos');
		$endereco = $_POST['endereco'];

		$this->valida($codigo);
		$this->valida($titulo);

		// Instancia
		$banners = new model_banners();

		$banners->altera_banner(array(
			$titulo,
			$endereco,
			$grupo_produtos
		), $codigo);
	 	
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}

	public function imagem(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();
		// Instancia
		$banners = new model_banners();		

		$codigo = $this->get('codigo');

		$diretorio = "arquivos/img_banners/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					$data = $banners->carrega($codigo);					
					$data_grupo = $banners->carrega_grupo($data->grupo);

					if($data_grupo->largura){

						//calcula a 
						$largura_g = $data_grupo->largura;
						$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

						//redimenciona
						$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
					}
				}
				
				//grava banco
				$banners->altera_imagem($nome_arquivo, $codigo);
				
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
			} else {
				
				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
				
			}

		}
		
	}

	public function apagar_imagem(){
		
		// Instancia
		$banners = new model_banners();

		$codigo = $this->get('codigo');
		
		if($codigo){

			$data = $banners->carrega($codigo);

			if($data->imagem){
				unlink('arquivos/img_banners/'.$data->imagem);
			}
			//grava banco
			$banners->altera_imagem("", $codigo);

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function apagar_varios(){
		
		// Instancia
		$banners = new model_banners();

		$grupo = $this->get('grupo');

		foreach ($banners->lista($grupo) as $key => $value) {			 
			
			if($this->post('apagar_'.$value['id']) == 1){
				
				if($value['imagem']){
					unlink('arquivos/img_banners/'.$value['imagem']);
				}

				$banners->apaga_banner($value['codigo']);
				
			}
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/inicial/grupo/'.$grupo);
		
	}
	
	// ORDEM

	public function ordem(){

		// Instancia
		$banners = new model_banners();

		$codigo = $this->post('codigo');
		$list = $this->post('list');

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$banners->altera_ordem($ordem, $codigo);

	}

	// GRUPOS

	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		// Instancia
		$banners = new model_banners();
 		
		$dados['categorias'] = $banners->lista_grupos();		
		
		$this->view('banners.categorias', $dados);
	}

	public function novo_grupo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Nova Categoria";

		$this->view('banners.categorias.nova', $dados);
	}

	public function novo_grupo_grv(){

		$titulo = $this->post('titulo');
		$largura = $this->post('largura');
		$altura = $this->post('altura');

		$this->valida($titulo);
		$this->valida($largura);
		$this->valida($altura);
		
		// Instancia
		$banners = new model_banners();

		$codigo = $this->gera_codigo();

		$banners->adiciona_grupo(array(
			$codigo,
			$titulo,
			$largura,
			$altura
		));

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function alterar_grupo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar Categoria";

 		// Instancia
		$banners = new model_banners();

 		$codigo = $this->get('codigo');

		$dados['data'] = $banners->carrega_grupo($codigo);

		$this->view('banners.categorias.alterar', $dados);
	}

	public function alterar_grupo_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$largura = $this->post('largura');
		$altura = $this->post('altura');

		$this->valida($codigo);
		$this->valida($titulo);
		$this->valida($largura);
		$this->valida($altura);		
		
		// Instancia
		$banners = new model_banners();

		$banners->altera_grupo(array(
			$titulo,
			$largura,
			$altura
		), $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

	public function apagar_grupos(){
		
		// Instancia
		$banners = new model_banners();

		foreach ($banners->lista_grupos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				$banners->apaga_grupo($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');		
	}

}