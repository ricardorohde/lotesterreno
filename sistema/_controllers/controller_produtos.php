<?php

class produtos extends controller {
	
	protected $_modulo_nome = "Produtos";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(73);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";		

		// instancia
		$produtos = new model_produtos();
		
		$dados['lista'] = $produtos->lista();
		
		$this->view('produtos', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		$this->view('produtos.novo', $dados);
	}

	public function novo_produto(){
		
		$fotos = $this->get('fotos');

		// instancia
		$produtos = new model_produtos();

		$codigo = $this->gera_codigo();
		$produtos->novo_produto($codigo);

		if($fotos == 1){

			$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/imagem'); 

		} else {

			$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/dados');

		}
	}
	
	public function alterar_produto(){
		
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

 		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();		

		$dados['data'] = $produtos->carrega_produto($codigo);
		$dados['valor_falso'] = $valores->trata_valor($dados['data']->valor_falso);
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		
 		//imagens
		$dados['imagens'] = $produtos->lista_imagens($dados['data']->codigo);

 		// categorias
		$dados['categorias'] = $produtos->lista_categorias($codigo);

 		// tamanhos
		$dados['tamanhos'] = $produtos->lista_tamanhos($codigo);

 		// cores
		$dados['cores'] = $produtos->lista_cores($codigo);

 		// variações
		$dados['variacoes'] = $produtos->lista_variacoes($codigo);
		
 		// estoque
		$dados['estoque'] = $produtos->listar_estoque($codigo);

		// marcas
		$dados['marcas'] = $produtos->lista_marcas($dados['data']->marca);

 		// entrega auto
		$dados['lista_entrega_auto'] = $produtos->entrega_auto($codigo);


		$this->view('produtos.alterar', $dados);
	}

	public function alterar_produto_dados(){

		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		$ref = $this->post('ref');	

		if($ref){
			if(!$produtos->verifica_ref($ref, $codigo)){
				$this->msg('O codigo de refêrencia esta sendo utilizado por outro produto, altere e tente novamente!');
				$this->volta(1);
			}
		}
		
		$valor = $this->post('valor');
		$valor_formatado = $valores->trata_valor_banco($valor);

		$valor_falso = $this->post('valor_falso');
		$valor_falso_formatado = $valores->trata_valor_banco($valor_falso);
		$esconder_valor = $this->post('esconder_valor');

		$previa = $_POST['previa'];
		$descricao = $_POST['descricao'];

		$digital = $this->post('digital');
		$digital_entrega = $this->post('digital_entrega'); 
		
		$semestoque = $this->post('semestoque');
		$destaque = $this->post('destaque');	
		$esconder = $this->post('esconder');
		$fretegratis  = $this->post('fretegratis');
		$msg_restrito  = $this->post('msg_restrito');
		$marca  = $this->post('marca');
		
		$this->valida($titulo);
		$this->valida($codigo);
		
		$produtos->altera_produto_dados(array(
			$titulo,
			$ref,
			$valor_formatado,
			$valor_falso_formatado,
			$previa,
			$descricao,
			$fretegratis,
			$destaque,
			$semestoque,
			$esconder,
			$digital,
			$digital_entrega,
			$esconder_valor,
			$marca,
			$msg_restrito
		), $codigo);
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/dados');
	}

	public function alterar_produto_categorias(){

		$codigo = $this->post('codigo');

		// instancia
		$produtos = new model_produtos();

		foreach ($produtos->lista_categorias_todas() as $key => $value) {
			
			$produtos->confere_categoria($value['codigo'], $codigo);

			if( $this->post('categoria_'.$value['id']) ){				 

				if(!$produtos->confere_categoria($value['codigo'], $codigo)){					
					$produtos->adiciona_produto_categoria($value['codigo'], $codigo);					
				}

			} else {
				
				if($produtos->confere_categoria($value['codigo'], $codigo)){					
					$produtos->apaga_produto_categoria($value['codigo'], $codigo);					
				}
				
			}
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/categorias');
	}

	public function alterar_produto_tamanhos(){

		$codigo = $this->post('codigo');

		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();

		foreach ($produtos->lista_tamanhos($codigo) as $key => $value) {			 

			if( $this->post('tamanho_'.$value['id']) == 1 ){

				$valor_tratado = $valores->trata_valor_banco($this->post("valor_".$value['id']));

				if(!$value['check_prod']){
					$produtos->adiciona_produto_tamanho($value['codigo'], $codigo, $valor_tratado);					
				} else {
					$produtos->altera_produto_tamanho($value['codigo'], $codigo, $valor_tratado);	
				}

			} else {
				
				if($value['check_prod']){				
					$produtos->apaga_produto_tamanho($value['codigo'], $codigo);					
				}
				
			}
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/tamanhos');
	}

	public function alterar_produto_cores(){

		$codigo = $this->post('codigo');

		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();

		foreach ($produtos->lista_cores($codigo) as $key => $value) {			 

			if( $this->post('cor_'.$value['id']) == 1 ){

				$valor_tratado = $valores->trata_valor_banco($this->post("valor_".$value['id']));

				if(!$value['check_prod']){
					$produtos->adiciona_produto_cor($value['codigo'], $codigo, $valor_tratado);					
				} else {
					$produtos->altera_produto_cor($value['codigo'], $codigo, $valor_tratado);	
				}

			} else {
				
				if($value['check_prod']){				
					$produtos->apaga_produto_cor($value['codigo'], $codigo);					
				}
				
			}
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/cores');
	}

	public function alterar_produto_variacoes(){

		$codigo = $this->post('codigo');

		// instancia
		$produtos = new model_produtos();
		$valores = new model_valores();

		foreach ($produtos->lista_variacoes($codigo) as $key => $value) {			 

			if( $this->post('variacao_'.$value['id']) == 1 ){

				$valor_tratado = $valores->trata_valor_banco($this->post("valor_".$value['id']));

				if(!$value['check_prod']){
					$produtos->adiciona_produto_variacao($value['codigo'], $codigo, $valor_tratado);					
				} else {
					$produtos->altera_produto_variacao($value['codigo'], $codigo, $valor_tratado);	
				}

			} else {
				
				if($value['check_prod']){				
					$produtos->apaga_produto_variacao($value['codigo'], $codigo);					
				}
				
			}
			
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/variacoes');
	}	

	public function alterar_produto_frete(){

		$codigo = $this->post('codigo');
		$fretegratis = $this->post('fretegratis');
		$peso = $this->post('peso');
		$largura = $this->post('largura');
		$comprimento = $this->post('comprimento');
		$altura = $this->post('altura');

		if($codigo){

			// instancia
			$produtos = new model_produtos();
			
			$produtos->altera_produto_frete(array(
				$peso,
				$largura,
				$comprimento,
				$altura,
				$fretegratis
			), $codigo);

		}		

		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/frete');
	}

	public function apagar_varios(){
		
		$produtos = new model_produtos();

		foreach ($produtos->lista() as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){				 

				foreach ($produtos->lista_imagens($value['codigo']) as $key3 => $value3) {

					if( $value3['imagem'] ){
						unlink('arquivos/img_produtos_g/'.$value['codigo'].'/'.$value3['imagem']);
						unlink('arquivos/img_produtos_p/'.$value['codigo'].'/'.$value3['imagem']);						 
					}

				}

				$produtos->apagar_produto($value['codigo']);				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}



	// IMAGEM

	public function upload(){
		
		//carrega normal
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');
		$dados['codigo'] = $codigo;

		$this->view('enviar_imagens', $dados);
	}
	
	public function imagem_redimencionada(){

		$codigo = $this->post('codigo');
		
		//pasta onde vai ser salvo os arquivos
		$pasta = "produtos";
		$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo."/";

		//confere e cria pasta se necessario
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
		
		//carrega model de gestao de imagens
		$img = new model_arquivos_imagens();
		$produtos = new model_produtos();
		
		// Recuperando imagem em base64
		// Exemplo: data:image/png;base64,AAAFBfj42Pj4
		$imagem = $_POST['imagem'];
		$nome_original = $this->post('nomeimagem');

		$nome_foto  = $img->trata_nome($nome_original);
		$extensao = $img->extensao($nome_original);
		
		// Separando tipo dos dados da imagem
		// $tipo: data:image/png
		// $dados: base64,AAAFBfj42Pj4
		list($tipo, $dados) = explode(';', $imagem);
		
		// Isolando apenas o tipo da imagem
		// $tipo: image/png
		list(, $tipo) = explode(':', $tipo);
		
		// Isolando apenas os dados da imagem
		// $dados: AAAFBfj42Pj4
		list(, $dados) = explode(',', $dados);

		// Convertendo base64 para imagem
		$dados = base64_decode($dados);

		// Gerando nome aleatório para a imagem
		$nome = md5(uniqid(time()));

		// Salvando imagem em disco
		if(file_put_contents($diretorio_g.$nome_foto, $dados)) {			

				//confere e se jpg reduz a miniatura
			if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
				$largura_g = 1000;
				$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
					// foto minuatura
				$largura_p = 300;
				$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
					//redimenciona
				$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);

					//redimenciona miniatura 
				if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
				}

			} else {

					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
				copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);

			}

				//definições de mascara
			$cod_mascara = $produtos->carrega_mascara();				
			if($cod_mascara){
				$mascara = new model_mascara();
				$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
			}

				//grava banco e retorna id
			$ultid = $produtos->adiciona_imagem(array(
				$codigo,
				$nome_foto
			));

				//ordem
			$ordem = $produtos->ordem_imagens($codigo);								
			if($ordem){
				$novaordem = $ordem.",".$ultid;
			} else {
				$novaordem = $ultid;
			}
				// grava ordem
			$produtos->salva_ordem_imagem($codigo, $novaordem);
		}

	}

	public function imagem_manual(){

		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');		

		$nome_original = $_FILES['arquivo']['name'];

		//definições de pasta
		$pasta = "produtos";
		$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo."/";
		
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
		
		$img = new model_arquivos_imagens();
		$produtos = new model_produtos();

		if($tmp_name) {

			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);
			
			if(copy($tmp_name, $diretorio_g.$nome_foto)){
				
				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){
					
					// foto grande
					$largura_g = 1000;
					$altura_g = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($diretorio_g.$nome_foto, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
					
					//redimenciona miniatura 
					if(!$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto)){
						//se não redimencionar copia padrao
						copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					}
					
				} else {
					
					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
				}
				
				//definições de mascara
				$cod_mascara = $produtos->carrega_mascara();				
				if($cod_mascara){
					$mascara = new model_mascara();
					$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
				}

				//grava banco e retorna id
				$ultid = $produtos->adiciona_imagem(array(
					$codigo,
					$nome_foto
				));

				//ordem
				$ordem = $produtos->ordem_imagens($codigo);								
				if($ordem){
					$novaordem = $ordem.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				// grava ordem
				$produtos->salva_ordem_imagem($codigo, $novaordem);

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar_produto/codigo/".$codigo."/aba/imagem");
		}
		
	}

	public function ordenar_imagem(){

		$codigo = $this->post('codigo');
		$list = $this->post('list');
		
		$this->valida($codigo);
		$this->valida($list);

		// instancia
		$produtos = new model_produtos();

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		//grava
		$produtos->salva_ordem_imagem($codigo, $ordem);
	}	 

	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			// instancia
			$produtos = new model_produtos();
			$imagem = $produtos->seleciona_imagem($id); 			
 			//imagem
			if($imagem->imagem){
				unlink('arquivos/img_produtos_g/'.$codigo.'/'.$imagem->imagem);
				unlink('arquivos/img_produtos_p/'.$codigo.'/'.$imagem->imagem);
			}
			//apaga
			$produtos->apagar_imagem($id);

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/imagem');
	}

	public function girar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		$produtos = new model_produtos();
		$arquivos = new model_arquivos_imagens();

		$data = $produtos->seleciona_imagem($id);
		$nome_antigo = $data->imagem;

		$extensao = $arquivos->extensao($data->imagem);
		$novo_nome = substr($nome_antigo, 0, strlen($nome_antigo) - 25).'.'.$extensao;
		$novo_nome_tratado = $arquivos->trata_nome($novo_nome);


		$caminho = "arquivos/img_produtos_g/".$codigo."/".$nome_antigo;
		// destino
		$destino = "arquivos/img_produtos_g/".$codigo."/".$novo_nome_tratado;

 		// gira a imagem
		if($arquivos->girar_imagem($caminho, $destino)){

	 			///////////////////////////////
				// imagem pequena

			$caminho = "arquivos/img_produtos_p/".$codigo."/".$nome_antigo;
				// destino
			$destino = "arquivos/img_produtos_p/".$codigo."/".$novo_nome_tratado;

		 		// gira a imagem
			if($arquivos->girar_imagem($caminho, $destino)){

				 	// remove imagem antiga
				unlink("arquivos/img_produtos_g/".$codigo."/".$nome_antigo);
				unlink("arquivos/img_produtos_p/".$codigo."/".$nome_antigo);

			 		// grava nova imagem
				$produtos->altera_imagem($novo_nome_tratado, $id);

		 			// direciona
				$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$codigo.'/aba/imagem');

			} else {
				$this->msg('Não foi possivel girar esta imagem!'); 
				$this->volta(1);			
			}

		} else {
			$this->msg('Não foi possivel girar esta imagem!');
			$this->volta(1);
		}

	}


	// mascara Marca dgua

	public function mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marca d'água"; 		 

		$mascaras = new model_mascara();
		$produtos = new model_produtos();

		$mascara = $produtos->carrega_mascara();
		$dados['lista'] = $mascaras->lista($mascara);

		$this->view('produtos.mascara', $dados);
	}	

	public function mascara_grv(){
		
		$codigo = $this->post('codigo');
		
		$produtos = new model_produtos();
		$produtos->altera_mascara($codigo);

		$this->irpara(DOMINIO.$this->_controller.'/mascara');
	}



	// GRUPOS / CATEGORIAS

	public function categorias(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$produtos = new model_produtos();
		
		// categorias
		$dados['categorias'] = $produtos->lista_categorias();

		$this->view('produtos.categorias', $dados);
	}

	public function nova_categoria(){

		$dados['_base'] = $this->base();

		$produtos = new model_produtos();

		// categorias
		$dados['categorias'] = $produtos->lista_categorias();

		$this->view('produtos.categorias.nova', $dados);
	}

	public function nova_categoria_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		$produtos = new model_produtos();
		
		$codigo = $this->gera_codigo();
		
		$ultid = $produtos->adiciona_categoria(array(
			$codigo,
			$titulo
		));

		$ordem = $produtos->ordem_categorias(0);
		if($ordem){
			$novaordem = $ordem.",".$ultid;
		} else {
			$novaordem = $ultid;
		}
		$produtos->adiciona_ordem_categoria($novaordem, 0);

		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}
	
	public function alterar_categoria(){
		
		$dados['_base'] = $this->base();

		$codigo = $this->get('codigo');

		$produtos = new model_produtos();

		$dados['data'] = $produtos->carrega_categoria($codigo);	 
		
		$this->view('produtos.categorias.alterar', $dados);
	}

	public function alterar_categoria_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');
		
		$this->valida($codigo);
		$this->valida($titulo);

		$produtos = new model_produtos();

		$produtos->alterar_categoria($titulo, $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function salva_ordem_categorias(){		

		$ordem = stripcslashes($_POST['ordem']);

		if($ordem){
			$data = json_decode($ordem, true);

			function converte_array_para_banco($jsonArray, $id_pai = 0) {
				// instancia
				$produtos = new model_produtos();
				$lista = "";

				foreach ($jsonArray as $subArray) {

					//aqui vai adicionar
					$lista .= $subArray['id'].",";

					if (isset($subArray['children'])) {
						converte_array_para_banco($subArray['children'], $subArray['id']);
					} else {
						//limpa pai
						$produtos->apaga_ordem_categoria($subArray['id']); 
					}
				}

				$novaordem = substr($lista,0,-1);			  	
				$produtos->adiciona_ordem_categoria($novaordem, $id_pai);
			}

			converte_array_para_banco($data);			
		}

		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}

	public function apagar_categoria(){
		
		$codigo = $this->get('codigo');

		$produtos = new model_produtos();

		$produtos->apaga_categoria($codigo);	 
		
		$this->irpara(DOMINIO.$this->_controller.'/categorias');		
	}


	// MARCAS

	public function marcas(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Marcas";

		// Instancia
		$produtos = new model_produtos(); 		
		$dados['lista'] = $produtos->lista_marcas();
		
		$this->view('produtos.marcas', $dados);
	}

	public function marcas_nova(){

		$dados['_base'] = $this->base();

		$this->view('produtos.marcas.nova', $dados);
	}

	public function marcas_nova_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->gera_codigo();

		$produtos->adiciona_marca(array(
			$codigo,
			$titulo
		));

		$this->irpara(DOMINIO.$this->_controller.'/marcas');		
	}

	public function marcas_alterar(){

		$dados['_base'] = $this->base();

 		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->get('codigo');

		$dados['data'] = $produtos->carrega_marca($codigo);

		$this->view('produtos.marcas.alterar', $dados);
	}

	public function marcas_alterar_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_marca(array(
			$titulo
		), $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/marcas');		
	}

	public function marcas_apagar(){
		
		// Instancia
		$produtos = new model_produtos();

		foreach ($produtos->lista_marcas() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				$produtos->apaga_marca($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/marcas');		
	}


	// TAMANHOS

	public function tamanhos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Tamanhos";

		// Instancia
		$produtos = new model_produtos();

		$dados['lista'] = $produtos->lista_tamanhos();		
		
		$this->view('produtos.tamanhos', $dados);
	}

	public function novo_tamanho(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo Tamanho";

		$this->view('produtos.tamanhos.novo', $dados);
	}

	public function novo_tamanho_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->gera_codigo();

		$produtos->adiciona_tamanho(array(
			$codigo,
			$titulo
		));

		$this->irpara(DOMINIO.$this->_controller.'/tamanhos');		
	}

	public function alterar_tamanho(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Tamanho";

 		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->get('codigo');

		$dados['data'] = $produtos->carrega_tamanho($codigo);

		$this->view('produtos.tamanhos.alterar', $dados);
	}

	public function alterar_tamanho_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_tamanho(array(
			$titulo
		), $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/tamanhos');		
	}

	public function apagar_tamanhos(){
		
		// Instancia
		$produtos = new model_produtos();

		foreach ($produtos->lista_tamanhos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				$produtos->apaga_tamanho($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/tamanhos');		
	}





	// CORES

	public function cores(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Cores";

		// Instancia
		$produtos = new model_produtos();

		$dados['lista'] = $produtos->lista_cores();		
		
		$this->view('produtos.cores', $dados);
	}

	public function nova_cor(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova Cor";

		$this->view('produtos.cores.nova', $dados);
	}

	public function nova_cor_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->gera_codigo();

		$produtos->adiciona_cor(array(
			$codigo,
			$titulo
		));

		$this->irpara(DOMINIO.$this->_controller.'/cores');		
	}

	public function alterar_cor(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Cor";

 		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->get('codigo');

		$dados['data'] = $produtos->carrega_cor($codigo);

		$this->view('produtos.cores.alterar', $dados);
	}

	public function alterar_cor_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_cor(array(
			$titulo
		), $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/cores');		
	}

	public function apagar_cores(){
		
		// Instancia
		$produtos = new model_produtos();

		foreach ($produtos->lista_cores() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				$produtos->apaga_cor($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/cores');		
	}





	// VARIAÇÕES

	public function variacoes(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Variações";

		// Instancia
		$produtos = new model_produtos();

		$dados['lista'] = $produtos->lista_variacoes();		
		
		$this->view('produtos.variacoes', $dados);
	}

	public function nova_variacao(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Nova Variação";

		$this->view('produtos.variacoes.nova', $dados);
	}

	public function nova_variacao_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);

		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->gera_codigo();

		$produtos->adiciona_variacao(array(
			$codigo,
			$titulo
		));

		$this->irpara(DOMINIO.$this->_controller.'/variacoes');		
	}

	public function alterar_variacao(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Variação";

 		// Instancia
		$produtos = new model_produtos();

		$codigo = $this->get('codigo');

		$dados['data'] = $produtos->carrega_variacao($codigo);

		$this->view('produtos.variacoes.alterar', $dados);
	}

	public function alterar_variacao_grv(){
		
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_variacao(array(
			$titulo
		), $codigo);

		$this->irpara(DOMINIO.$this->_controller.'/variacoes');		
	}

	public function apagar_variacoes(){
		
		// Instancia
		$produtos = new model_produtos();

		foreach ($produtos->lista_variacoes() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){
				
				$produtos->apaga_variacao($value['codigo']);

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/variacoes');		
	}





	// ESTOQUE
	public function estoque(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Estoque";

		// model
		$produtos = new model_produtos();
		$dados['lista'] = $produtos->listar_estoque();
		
		$this->view('produtos.estoque', $dados);
	}
	
	public function extrato_estoque(){

		$dados = array();
		$dados['_base'] = $this->base();
		
		$registro = $this->get('registro');
		
		// model
		$produtos = new model_produtos();		
		$dados['lista'] = $produtos->estoque_extrato($registro);
		
		$this->view('produtos.estoque.extrato', $dados);
	}

	public function alterar_estoque(){
		
		$dados = array();
		$dados['_base'] = $this->base();
		
		$produto = $this->get('produto');
		$tamanho = $this->get('tamanho');
		$cor = $this->get('cor');
		$variacao = $this->get('variacao');

		$retorno = $this->get('retorno');
		if(!$retorno){
			$retorno = 1;
		}

		$dados['retorno'] = $retorno;
		$dados['produto'] = $produto;
		$dados['tamanho'] = $tamanho;
		$dados['cor'] = $cor;
		$dados['variacao'] = $variacao;
		
		// model
		$produtos = new model_produtos();
		
		$dados['lista_produtos'] = $produtos->lista();
		$dados['lista_tamanhos'] = $produtos->lista_tamanhos();
		$dados['lista_cores'] = $produtos->lista_cores();
		$dados['lista_variacoes'] = $produtos->lista_variacoes();
		
		if($produto){
			$dados['quantidade'] = $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);
		} else {
			$dados['quantidade'] = 0;
		}

		$this->view('produtos.estoque.alterar', $dados);
	}
	
	public function alterar_estoque_grv(){
		
		$produto = $this->post('produto');

		$this->valida($produto);
		
		$tamanho = $this->post('tamanho');
		$cor = $this->post('cor');
		$variacao = $this->post('variacao');
		$quantidade = $this->post('quantidade');

		$retorno = $this->post('retorno');
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_estoque($produto, $tamanho, $cor, $variacao, $quantidade);

		if($retorno == 1){
			$this->irpara(DOMINIO.$this->_controller.'/estoque');
		} else {
			$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$produto.'/aba/estoque');
		}
		
	}
	
	public function estoque_quantidade(){
		
		$produto = $this->post('produto');

		if($produto){

			$tamanho = $this->post('tamanho');
			$cor = $this->post('cor');
			$variacao = $this->post('variacao');
			$quantidade = $this->post('quantidade');
			
			// Instancia
			$produtos = new model_produtos();

			echo $produtos->estoque_quantidade($produto, $tamanho, $cor, $variacao);

		} else {
			echo '0';
		}

	}
	
	// ENTRGA AUTOMATIVA
	
	public function alterar_entrega_auto(){
		
		$dados['_base'] = $this->base();
		
		$produto = $this->get('produto');
		$tamanho = $this->get('tamanho');
		$cor = $this->get('cor');
		$variacao = $this->get('variacao');

		$retorno = $this->get('retorno');
		if(!$retorno){
			$retorno = 1;
		}

		$dados['retorno'] = $retorno;
		$dados['produto'] = $produto;
		$dados['tamanho'] = $tamanho;
		$dados['cor'] = $cor;
		$dados['variacao'] = $variacao;
		
		// Instancia
		$produtos = new model_produtos();
		
		$dados['lista_produtos'] = $produtos->lista();
		$dados['lista_tamanhos'] = $produtos->lista_tamanhos();
		$dados['lista_cores'] = $produtos->lista_cores();
		$dados['lista_variacoes'] = $produtos->lista_variacoes();
		
		if($produto){
			$dados['texto'] = $produtos->entrega_auto_texto($produto, $tamanho, $cor, $variacao);
		} else {
			$dados['texto'] = '';
		}

		$this->view('produtos.entrega.auto.alterar', $dados);
	}

	public function alterar_entrega_auto_grv(){
		
		$produto = $this->post('produto');

		$this->valida($produto);
		
		$tamanho = $this->post('tamanho');
		$cor = $this->post('cor');
		$variacao = $this->post('variacao');
		$texto = $this->post('texto');

		$retorno = $this->post('retorno');
		
		// Instancia
		$produtos = new model_produtos();

		$produtos->altera_entrega_texto($produto, $tamanho, $cor, $variacao, $texto);

		$this->irpara(DOMINIO.$this->_controller.'/alterar_produto/codigo/'.$produto.'/aba/entrega_auto');
	}

	public function texto_entrega_auto(){		 
		
		$produto = $this->post('produto');

		if($produto){

			$tamanho = $this->post('tamanho');
			$cor = $this->post('cor');
			$variacao = $this->post('variacao');

			// Instancia
			$produtos = new model_produtos();

			echo $produtos->entrega_auto_texto($produto, $tamanho, $cor, $variacao);

		} else {
			echo '';
		}

	}	 

}