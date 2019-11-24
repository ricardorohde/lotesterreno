<?php

Class model_produtos extends model{
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// tabelas

	private $tab_produtos 			= "produto";
	private $tab_categorias 		= "produto_categoria";
	private $tab_categorias_ordem 	= "produto_categoria_ordem";
	private $tab_categorias_prod 	= "produto_categoria_sel";
	private $tab_imagem 			= "produto_imagem";
	private $tab_imagem_ordem 		= "produto_imagem_ordem";
	private $tab_mascara 			= "produto_marcadagua";
	private $tab_marcas				= "marcas";
	private $tab_cores 				= "produto_cor";
	private $tab_cores_sel 			= "produto_cor_sel";
	private $tab_tamanhos 			= "produto_tamanho";
	private $tab_tamanhos_sel 		= "produto_tamanho_sel";
	private $tab_variacoes 			= "produto_variacao";	 
	private $tab_variacoes_sel 		= "produto_variacao_sel";
	private $tab_estoque 			= "produto_estoque";
	private $tab_estoque_registro 	= "produto_estoque_registro";
	private $tab_entrega			= "produto_entrega_auto";

	// LISTA

	public function lista(){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_produtos." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['ref'] = $data->ref;

			if($data->destaque == 1){
				$lista[$i]['destaque'] = "Sim";
			} else {
				$lista[$i]['destaque'] = "Não";
			}

			if($data->digital == 1){
				$lista[$i]['digital'] = "Sim";
			} else {
				$lista[$i]['digital'] = "Não";
			}
			
			$lista[$i]['estoque'] = $this->estoque_total($data->codigo);

			$i++;
		}

		return $lista;
	}	 
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega_produto($codigo){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_produtos." WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function novo_produto($codigo){ 
		
		$db = new mysql();
		$db->inserir($this->tab_produtos, array(
			"codigo"	=>$codigo,
			"titulo"	=>'Novo Produto Sem Nome'
		));
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function verifica_ref($ref, $codigo){
		
		$conexao = new mysql();
		$coisas_ref = $conexao->Executar("select id from ".$this->tab_produtos." where ref='$ref' AND codigo!='$codigo' ");
		$linhas_ref = $coisas_ref->num_rows;
		if($linhas_ref != 0){
			return false;
		} else {
			return true;
		}

	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_produto_dados($vars, $codigo){
		
		$db = new mysql();
		$db->alterar($this->tab_produtos, array(
			"titulo"				=>$vars[0],
			"ref"					=>$vars[1],
			"valor"					=>$vars[2],
			"valor_falso"			=>$vars[3],
			"previa"				=>$vars[4],
			"descricao"				=>$vars[5],
			"fretegratis"			=>$vars[6],
			"destaque"				=>$vars[7],
			"semestoque"			=>$vars[8],
			"esconder"				=>$vars[9],
			"digital"				=>$vars[10],
			"digital_entrega"	 	=>$vars[11],
			"esconder_valor" 		=>$vars[12],
			"marca" 				=>$vars[13],
			"msg_restrito"			=>$vars[14]
		), " codigo='$codigo' ");
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_produto_frete($vars, $codigo){
		
		$db = new mysql();
		$db->alterar($this->tab_produtos, array(
			"peso"			=>$vars[0],
			"largura"		=>$vars[1],
			"comprimento"	=>$vars[2],
			"altura"		=>$vars[3],
			"fretegratis"	=>$vars[4]
		), " codigo='$codigo' ");
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apagar_produto($codigo){
		
		$db = new mysql();
		$db->apagar($this->tab_produtos, " codigo='$codigo' ");
		
		$db = new mysql();
		$db->apagar($this->tab_categorias_prod, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_imagem, " codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_imagem_ordem, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_tamanhos_sel, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_cores_sel, " produto_codigo='$codigo' ");

		$db = new mysql();
		$db->apagar($this->tab_variacoes_sel, " produto_codigo='$codigo' ");

	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function confere_categoria($categoria, $codigo){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM ".$this->tab_categorias_prod." where produto_codigo='$codigo' AND categoria_codigo='$categoria' ");
		$linhas = $exec->num_rows;

		if($linhas == 0){
			return false;
		} else {
			return true;
		}
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_produto_categoria($categoria, $codigo){		
		$db = new mysql();
		$db->inserir($this->tab_categorias_prod, array(
			"produto_codigo"=>"$codigo",
			"categoria_codigo"=>"$categoria"
		));
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apaga_produto_categoria($categoria, $codigo){		
		$db = new mysql();
		$db->apagar($this->tab_categorias_prod, " produto_codigo='$codigo' AND categoria_codigo='$categoria' ");
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_produto_tamanho($tamanho, $codigo, $valor){		
		$db = new mysql();
		$db->inserir($this->tab_tamanhos_sel, array(
			"produto_codigo"=>"$codigo",
			"tamanho_codigo"=>"$tamanho",
			"valor"=>"$valor"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_produto_tamanho($tamanho, $codigo, $valor){		
		$db = new mysql();
		$db->alterar($this->tab_tamanhos_sel, array(
			"valor"=>"$valor"
		), " produto_codigo='$codigo' AND tamanho_codigo='$tamanho' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apaga_produto_tamanho($tamanho, $codigo){		
		$db = new mysql();
		$db->apagar($this->tab_tamanhos_sel, " produto_codigo='$codigo' AND tamanho_codigo='$tamanho' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_produto_cor($cor, $codigo, $valor){		
		$db = new mysql();
		$db->inserir($this->tab_cores_sel, array(
			"produto_codigo"=>"$codigo",
			"cor_codigo"=>"$cor",
			"valor"=>"$valor"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_produto_cor($cor, $codigo, $valor){		
		$db = new mysql();
		$db->alterar($this->tab_cores_sel, array(
			"valor"=>"$valor"
		), " produto_codigo='$codigo' AND cor_codigo='$cor' ");
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apaga_produto_cor($cor, $codigo){		
		$db = new mysql();
		$db->apagar($this->tab_cores_sel, " produto_codigo='$codigo' AND cor_codigo='$cor' ");
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function adiciona_produto_variacao($variacao, $codigo, $valor){		
		$db = new mysql();
		$db->inserir($this->tab_variacoes_sel, array(
			"produto_codigo"=>"$codigo",
			"variacao_codigo"=>"$variacao",
			"valor"=>"$valor"
		));
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_produto_variacao($variacao, $codigo, $valor){		
		$db = new mysql();
		$db->alterar($this->tab_variacoes_sel, array(
			"valor"=>"$valor"
		), " produto_codigo='$codigo' AND variacao_codigo='$variacao' ");
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apaga_produto_variacao($variacao, $codigo){		
		$db = new mysql();
		$db->apagar($this->tab_variacoes_sel, " produto_codigo='$codigo' AND variacao_codigo='$variacao' ");
	}




	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// IMAGENS

	public function lista_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM ".$this->tab_imagem_ordem." WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){

			$order = explode(',', $data_ordem->data); 

			foreach($order as $key => $value){

				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM ".$this->tab_imagem." WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                

				if(isset($data_img->imagem)){

					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_produtos_g/'.$codigo.'/'.$data_img->imagem;
					}

					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem'] = $data_img->imagem;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_produtos_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_produtos_g/'.$codigo.'/'.$data_img->imagem;

					$n++;
				}
			}
		}

		return $imagens;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function ordem_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM ".$this->tab_imagem_ordem." WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();

		if(isset($data_ordem->data)){
			return $data_ordem->data; 
		} else {
			return false;
		}
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function salva_ordem_imagem($codigo, $ordem){ 

		$db = new mysql();
		$db->inserir($this->tab_imagem_ordem, array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));
		
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function seleciona_imagem($id){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_imagem." WHERE id='$id' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_imagem($vars){ 

		$db = new mysql();
		$db->inserir($this->tab_imagem, array(
			"codigo"	=>$vars[0],
			"imagem"	=>$vars[1]
		));
		$ultid = $db->ultimo_id();

		return $ultid;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apagar_imagem($codigo){
		
		$db = new mysql();
		$db->apagar($this->tab_imagem, " id='$codigo' ");
		
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_imagem($imagem, $id){

		$db = new mysql();
		$db->alterar($this->tab_imagem, array(
			"imagem"	=>$imagem
		), " id='$id' " );

	}




	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM

	public function carrega_mascara(){

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_mascara." WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo){

		$db = new mysql();
		$db->alterar($this->tab_mascara, array(			 
			"codigo"	=>$codigo
		), " id='1' " );

	}
	
	
	
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CATEGORIAS

	public function lista_categorias($produto = 0){ 
		
		$tab_categorias_ordem = $this->tab_categorias_ordem;
		$tab_categorias = $this->tab_categorias;
		$tab_categorias_prod = $this->tab_categorias_prod;
		
		function montaCategorias($id_pai, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto){
			
			$i = 0;
			$lista = array();

			$db = new mysql();
			$exec = $db->Executar("SELECT * FROM ".$tab_categorias_ordem." WHERE id_pai='$id_pai' ORDER BY id desc limit 1");
			$data = $exec->fetch_object();

			if(isset($data->data)){

				$order = explode(',', $data->data);
				foreach($order as $key => $value){

					$db = new mysql();
					$exec = $db->Executar("SELECT * FROM ".$tab_categorias." WHERE id='$value' ");
					$data = $exec->fetch_object();

					if(isset($data->titulo)){
						
						$lista[$i]['id'] = $value;
						$lista[$i]['id_pai'] = $id_pai;
						$lista[$i]['codigo'] = $data->codigo;
						$lista[$i]['titulo'] = $data->titulo;
						$lista[$i]['subcategorias'] = montaCategorias($value, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);
						
						if($produto != 0){
							
							$exec = new mysql();
							$coisas_confere = $exec->Executar("SELECT id FROM ".$tab_categorias_prod." WHERE categoria_codigo='$data->codigo' AND produto_codigo='$produto' ");
							$data_confere = $coisas_confere->fetch_object();

							if(isset($data_confere->id)){
								$lista[$i]['check_prod'] = true;
							} else {
								$lista[$i]['check_prod'] = false;
							}

						}

						$i++;
					}
				}
			}
			return $lista;
		}
		$lista = montaCategorias(0, $tab_categorias, $tab_categorias_ordem, $tab_categorias_prod, $produto);

        //echo "<pre>"; print_r($lista); echo "</pre>"; exit;

		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function lista_categorias_todas(){
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_categorias." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['id_pai'] = $data->id_pai;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo; 
			
			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function ordem_categorias($id_pai){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_categorias_ordem." WHERE id_pai='$id_pai' order by id desc limit 1");
		return $exec->fetch_object()->data;		
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function carrega_categoria($codigo){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_categorias." WHERE codigo='$codigo' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function apaga_ordem_categoria($id_pai){
		$db = new mysql();
		$db->apagar($this->tab_categorias_ordem, " id_pai='$id_pai' "); 		 
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_ordem_categoria($ordem, $id_pai){ 		
		$db = new mysql();
		$db->inserir($this->tab_categorias_ordem, array(
			"id_pai"=>"$id_pai",
			"data"=>"$ordem"
		));
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 

	public function adiciona_categoria($vars){

		$db = new mysql();
		$db->inserir($this->tab_categorias, array(
			"id_pai"	=>'0',
			"codigo"	=>$vars[0],
			"titulo"	=>$vars[1]
		));
		$ultid = $db->ultimo_id();
		return $ultid;

	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function alterar_categoria($titulo, $codigo){

		$db = new mysql();
		$db->alterar($this->tab_categorias, array(			 
			"titulo"	=>$titulo
		), " codigo='$codigo' " );

	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function apaga_categoria($codigo){
		
		$db = new mysql();
		$db->apagar($this->tab_categorias,  " codigo='$codigo' " );
		
	}





	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// TAMANHOS

	public function lista_tamanhos($codigo = null){  // o codigo é do produto

		$lista = array();

		$valores = new model_valores();	 

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_tamanhos." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM ".$this->tab_tamanhos_sel." WHERE tamanho_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();
			
			if(isset($data_confere->id)){
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}
			
			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_tamanho($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_tamanhos." where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_tamanho($vars){

		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_tamanhos, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_tamanho($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_tamanhos, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_tamanho($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_tamanhos, " codigo='$codigo' ");

	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MARCAS

	public function lista_marcas($codigo = null){  // o codigo é do produto

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_marcas." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;

			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}
			
			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_marca($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_marcas." where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_marca($vars){

		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_marcas, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_marca($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_marcas, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_marca($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_marcas, " codigo='$codigo' ");

	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// CORES

	public function lista_cores($codigo = null){  // o codigo é do produto

		$lista = array();

		$valores = new model_valores();	

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_cores." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			
			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM ".$this->tab_cores_sel." WHERE cor_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();
			
			if(isset($data_confere->id)){
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_cor($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_cores." where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_cor($vars){

		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_cores, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_cor($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_cores, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_cor($codigo){

		// executa
		$db = new mysql();
		$db->apagar($this->tab_cores, " codigo='$codigo' ");

	}




	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// VARIAÇÕES

	public function lista_variacoes($codigo = null){ // o codigo é do produto

		$lista = array();

		$valores = new model_valores();	

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_variacoes." order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			
			$exec2 = new mysql();
			$confere = $exec2->Executar("SELECT id, valor FROM ".$this->tab_variacoes_sel." WHERE variacao_codigo='$data->codigo' AND produto_codigo='$codigo' ");
			$data_confere = $confere->fetch_object();
			
			if(isset($data_confere->id)){
				$lista[$i]['check_prod'] = true;
				$lista[$i]['valor'] = $valores->trata_valor($data_confere->valor);
			} else {
				$lista[$i]['check_prod'] = false;
				$lista[$i]['valor'] = "0,00";
			}

			$i++;
		}
		return $lista;
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function carrega_variacao($codigo){
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM ".$this->tab_variacoes." where codigo='$codigo' ");
		return $exec->fetch_object();
	}
	
	///////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_variacao($vars){

		$dados = array(
			'codigo'=>$vars[0],
			'titulo'=>$vars[1]
		);
		// executa
		$db = new mysql();
		$db->inserir($this->tab_variacoes, $dados);
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function altera_variacao($vars, $codigo){

		$dados = array(
			'titulo'	=>$vars[0]
		);
		// executa
		$db = new mysql();
		$db->alterar($this->tab_variacoes, $dados, " codigo='$codigo' ");
	}

	///////////////////////////////////////////////////////////////////////////
	//

	public function apaga_variacao($codigo){
		
		// executa
		$db = new mysql();
		$db->apagar($this->tab_variacoes, " codigo='$codigo' ");

	}





	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ESTOQUE

	public function listar_estoque($produto = null){

		$lista = array();
		$i = 0;

		$db = new mysql();
		if(!$produto){
			$exec = $db->executar("SELECT * FROM ".$this->tab_estoque." order by produto asc");
		} else {
			$exec = $db->executar("SELECT * FROM ".$this->tab_estoque." where produto='$produto' order by produto asc");
		}

		while($data = $exec->fetch_object()) {

			$produto = $this->carrega_produto($data->produto);

			if($produto){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['registro'] = $data->registro;
				$lista[$i]['produto'] = $data->produto;
				$lista[$i]['produto_titulo'] = $produto->titulo;
				$lista[$i]['produto_ref'] = $produto->ref;

				if( ($data->tamanho) AND ($data->tamanho != '-') ){
					$tamanho = $this->carrega_tamanho($data->tamanho);
					$lista[$i]['tamanho_titulo'] = $tamanho->titulo;
					$lista[$i]['tamanho'] = $data->tamanho;
				} else {
					$lista[$i]['tamanho_titulo'] = "-";
					$lista[$i]['tamanho'] = "-";
				}			

				if( ($data->cor) AND ($data->cor != '-') ){ 
					$cor = $this->carrega_cor($data->cor);
					$lista[$i]['cor_titulo'] = $cor->titulo;
					$lista[$i]['cor'] = $data->cor;
				} else {
					$lista[$i]['cor_titulo'] = "-";
					$lista[$i]['cor'] = "-";
				}

				if( ($data->variacao) AND ($data->variacao != '-') ){
					$variacao = $this->carrega_variacao($data->variacao);
					$lista[$i]['variacao_titulo'] = $variacao->titulo;
					$lista[$i]['variacao'] = $data->variacao;
				} else {
					$lista[$i]['variacao_titulo'] = "-";
					$lista[$i]['variacao'] = "-";
				}

				$lista[$i]['quantidade'] = $data->quantidade;

				$i++;
			}	
		}
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function estoque_extrato($registro){
		
		$lista = array();
		$i = 0;
		
		if($registro){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM ".$this->tab_estoque_registro." where registro='$registro' order by data desc");
			while($data = $exec->fetch_object()) {
				
				$lista[$i]['data'] = date('d/m/y H:i', $data->data);
				$lista[$i]['quant_anterior'] = $data->quant_anterior;
				$lista[$i]['quant_final'] = $data->quant_final;
				$lista[$i]['descricao'] = $data->descricao;
				
				$i++;
			}

		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function estoque_quantidade($produto, $tamanho, $cor, $variacao){
		
		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM ".$this->tab_estoque." where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$data = $exec->fetch_object();
		
		if(isset($data->quantidade)){
			return $data->quantidade;
		} else {
			return 0;
		}
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_estoque($produto, $tamanho, $cor, $variacao, $quantidade){

		$db = new mysql();
		$exec = $db->executar("SELECT id, registro, quantidade FROM ".$this->tab_estoque." where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){

			$data = $exec->fetch_object();
			$quant_anterior = $data->quantidade;
			$registro = $data->registro;

			if($quantidade == $data->quantidade){
				$quant = 0;
				$descricao = "Registro Manual - Sem alterações";
			} else {
				if($quantidade > $data->quantidade){
					$quant = $quantidade - $data->quantidade;
					$descricao = "Registro Manual - Adicionado $quant item(s)";
				} else {
					$quant = $data->quantidade - $quantidade;
					$descricao = "Registro Manual - Removido $quant item(s)";
				}
			}
			
			$db = new mysql();
			$db->alterar($this->tab_estoque, array(
				"quantidade"=>"$quantidade"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
			
		} else {

			$registro = substr(time().rand(10000,99999),-15);

			$quant_anterior = 0;
			$quant = $quantidade;
			$descricao = "Registro Manual - Adicionado $quant item(s)";

			$db = new mysql();
			$db->inserir($this->tab_estoque, array(
				"registro"=>"$registro",
				"produto"=>"$produto",
				"tamanho"=>"$tamanho",
				"cor"=>"$cor",
				"variacao"=>"$variacao",				
				"quantidade"=>"$quantidade"
			));
			
		}

		$time = time();

		// registra alteracao
		$db = new mysql();
		$db->inserir($this->tab_estoque_registro, array(
			"registro"=>"$registro",
			"data"=>"$time",
			"quant"=>"$quant",
			"quant_anterior"=>"$quant_anterior",
			"quant_final"=>"$quantidade",
			"descricao"=>"$descricao"
		));

	}

	public function add_estoque_auto($produto, $tamanho, $cor, $variacao, $quant, $descricao){
		
		$db = new mysql();
		$exec = $db->executar("SELECT id, registro, quantidade FROM ".$this->tab_estoque." where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;
		
		if($linhas != 0){
			
			$data = $exec->fetch_object();
			$quant_anterior = $data->quantidade;
			$registro = $data->registro;
			
			$quantidade = $quant_anterior + $quant;			 
			
			$db = new mysql();
			$db->alterar($this->tab_estoque, array(
				"quantidade"=>"$quantidade"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
			
			$time = time();
			
			// registra alteracao
			$db = new mysql();
			$db->inserir($this->tab_estoque_registro, array(
				"registro"=>"$registro",
				"data"=>"$time",
				"quant"=>"$quant",
				"quant_anterior"=>"$quant_anterior",
				"quant_final"=>"$quantidade",
				"descricao"=>"$descricao"
			));
			
		}
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ESTOQUE TOTAL POR PRODUTO
	
	public function estoque_total($codigo){

		$total = 0;

		$db = new mysql();
		$exec = $db->executar("SELECT quantidade FROM ".$this->tab_estoque." where produto='$codigo' ");
		while($data = $exec->fetch_object()) {

			$total = $total + $data->quantidade;

		}

		return $total;
	}



	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ENTREGA AUTOMATICA

	public function entrega_auto($produto = null){

		$lista = array();

		$db = new mysql();
		if(!$produto){
			$exec = $db->executar("SELECT * FROM ".$this->tab_entrega." order by produto asc");
		} else {
			$exec = $db->executar("SELECT * FROM ".$this->tab_entrega." where produto='$produto' order by produto asc");
		}
		$i = 0;
		while($data = $exec->fetch_object()) {

			$produto = $this->carrega_produto($data->produto);

			if($produto){

				$lista[$i]['id'] = $data->id;
				$lista[$i]['produto'] = $data->produto;
				$lista[$i]['produto_titulo'] = $produto->titulo;
				$lista[$i]['produto_ref'] = $produto->ref;

				if( ($data->tamanho) AND ($data->tamanho != '-') ){
					$tamanho = $this->carrega_tamanho($data->tamanho);
					$lista[$i]['tamanho_titulo'] = $tamanho->titulo;
					$lista[$i]['tamanho'] = $data->tamanho;
				} else {
					$lista[$i]['tamanho_titulo'] = "-";
					$lista[$i]['tamanho'] = "-";
				}			
				
				if( ($data->cor) AND ($data->cor != '-') ){ 
					$cor = $this->carrega_cor($data->cor);
					$lista[$i]['cor_titulo'] = $cor->titulo;
					$lista[$i]['cor'] = $data->cor;
				} else {
					$lista[$i]['cor_titulo'] = "-";
					$lista[$i]['cor'] = "-";
				}
				
				if( ($data->variacao) AND ($data->variacao != '-') ){
					$variacao = $this->carrega_variacao($data->variacao);
					$lista[$i]['variacao_titulo'] = $variacao->titulo;
					$lista[$i]['variacao'] = $data->variacao;
				} else {
					$lista[$i]['variacao_titulo'] = "-";
					$lista[$i]['variacao'] = "-";
				}

				$lista[$i]['texto'] = $data->texto;

				$i++;
			}	
		}
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function entrega_auto_texto($produto, $tamanho, $cor, $variacao){
		
		$db = new mysql();
		$exec = $db->executar("SELECT texto FROM ".$this->tab_entrega." where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$data = $exec->fetch_object();
		
		if(isset($data->texto)){
			return $data->texto;
		} else {
			return '';
		}
		
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function altera_entrega_texto($produto, $tamanho, $cor, $variacao, $texto){

		$db = new mysql();
		$exec = $db->executar("SELECT id FROM ".$this->tab_entrega." where produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
		$linhas = $exec->num_rows;

		if($linhas != 0){

			$db = new mysql();
			$db->alterar($this->tab_entrega, array(
				"texto"=>"$texto"
			), " produto='$produto' AND tamanho='$tamanho' AND cor='$cor' AND variacao='$variacao' ");
			
		} else {
			
			$db = new mysql();
			$db->inserir($this->tab_entrega, array(
				"produto"=>"$produto",
				"tamanho"=>"$tamanho",
				"cor"=>"$cor",
				"variacao"=>"$variacao",		
				"texto"=>"$texto"
			));

		}

	}
	

}