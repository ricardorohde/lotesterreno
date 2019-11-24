<?php
class imoveis extends controller {
	
	public function init(){
	}	

	public function inicial(){
		$this->irpara(DOMINIO);
	}

	public function lista(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$valores = new model_valores();
		$imoveis = new model_imoveis();

		/////////////////////////////////
		// banners
		$banners = new model_banners();
		$dados['banner_principal'] = $banners->lista('147502866622777');

		/////////////////////////////////
		
		//configuracoes
		$itensporpagina = 999999999;
		$perpage = $itensporpagina;
		$numlinks = 999999999;

		//gets da busca principal
		$url_referencia = $this->get('referencia');
		$url_categoria = $this->get('categoria');
		$url_tipo = $this->get('tipo');
		$url_cidade = $this->get('cidade');

		if($this->get('startitem')){ $startitem = $this->get('startitem'); } else { $startitem = 0; }
		if($this->get('startpage')){ $startpage = $this->get('startpage'); } else { $startpage = 1; }
		if($this->get('endpage')){ $endpage = $this->get('endpage'); } else { $endpage = 0; }
		if($this->get('reven')){ $reven = $this->get('reven'); } else { $reven = 1; }
		if($this->get('bairro')){ $url_bairro = $this->get('bairro'); } else { $url_bairro = "bairro"; }
		if($this->get('dormitorios')){ $url_dormitorios = $this->get('dormitorios'); } else { $url_dormitorios = "dormitorios"; }
		if($this->get('suites')){ $url_suites = $this->get('suites'); } else { $url_suites = "suites"; }
		if($this->get('valor_maximo')){ $url_valor_maximo = $this->get('valor_maximo'); } else { $url_valor_maximo = "maximo"; }
		if($this->get('valor_minimo')){ $url_valor_minimo = $this->get('valor_minimo'); } else { $url_valor_minimo = "minimo"; }
		if($this->get('ordem')){ $url_ordem = $this->get('ordem'); } else { $url_ordem = 0; }

		$query = "SELECT * FROM imoveis WHERE status='1' AND";	
		
		if($url_categoria != 'categoria'){

			if($url_categoria == 'alugar'){
				$categoria_id = 5280;
			} else {
				$categoria_id = 5279;
				$categoria = "comprar";
			}
			
  			//categoria
			if($categoria_id){
				$query .= " categoria_id='$categoria_id' AND";
			}

		}

			/////////////////////////////////////////////////////////////////////////////////////////////////
			//regra de tipo
		if($url_tipo != 'tipo'){
			$query .= " tipo_id='$url_tipo' AND";
		}

			/////////////////////////////////////////////////////////////////////////////////////////////////
			//regra de cidade
		if($url_cidade != 'cidade'){
			$query .= " cidade='$url_cidade' AND";
		}

			/////////////////////////////////////////////////////////////////////////////////////////////////////
			//regra bairro
		if($url_bairro != 'bairro'){
			$query .= " bairro='$url_bairro' AND";
		}

			////////////////////////////////////////////////////////////////////////////////////////////////
			//dormitorios
		if($url_dormitorios != 'dormitorios'){
			if($url_dormitorios == 4){
				$query .= " quartos>='$url_dormitorios' AND";
			} else {
				$query .= " quartos='$url_dormitorios' AND";
			}
		}

			///////////////////////////////////////////////////////////////////////////////////////////////
			//suites
		if($url_suites != 'suites'){
			if($url_suites == 4){
				$query .= " suites>='$url_suites' AND";
			} else {
				$query .= " suites='$url_suites' AND";
			}
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////
		//valor minimo
		if($url_valor_minimo != 'minimo'){
			$query .= " valor>='$url_valor_minimo' AND";
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////
		//valor maximo
		if($url_valor_maximo != 'maximo'){
			$query .= " valor<='$url_valor_maximo' AND";
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////
		//finaliza query
		$query = substr($query, 0, strlen($query)-3);

		//////////////////////////////////////////////////////////////////////////////////////////////////
		// Busca por referencia
		if($url_referencia != 'referencia'){
			$query = "SELECT * FROM imoveis WHERE ref='$url_referencia'  ";
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////
		//verifica numero de itens

		$conexao = new mysql();
		$coisas_imoveis = $conexao->Executar($query);
		if($coisas_imoveis->num_rows) {
			$numitems = $coisas_imoveis->num_rows;
		} else {
			$numitems = 0;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////
		//regras de paginaçao
		if($numitems > 0) {
			$numpages = ceil($numitems / $perpage);
			if($startitem + $perpage > $numitems) { $enditem = $numitems; } else { $enditem = $startitem + $perpage; }
			if(!$startpage) { $startpage = 1; } 
			if($endpage == 0) { 
				if($numpages > $numlinks) { $endpage = $numlinks; } else { $endpage = $numpages; }
			}
		} else {
			$numpages = 0;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////
		// Regras de Ordem
		if($url_ordem == 0){
			$query .= " ORDER BY codigo desc LIMIT $startitem, $perpage";
		}
		if($url_ordem == 1){
			$query .= " ORDER BY data_alteracao asc LIMIT $startitem, $perpage";
		}
		if($url_ordem == 2){
			$query .= " ORDER BY valor desc LIMIT $startitem, $perpage";
		}
		if($url_ordem == 3){
			$query .= " ORDER BY valor asc LIMIT $startitem, $perpage";
		}
		
		//////////////////////////////////////////////////////////////////////////////////////////////////
		//echo $query;
		
		function trata_valor_busca($valor){
			$valor_array = explode(".", $valor);
			$valor = $valor_array[0];
			return $valor;
		}
		
		$dados['numitems'] = $numitems;
		$dados['numpages'] = $numpages;
		$dados['url_referencia'] = $url_referencia;
		$dados['url_categoria'] = $url_categoria;
		$dados['url_tipo'] = $url_tipo;
		$dados['url_cidade'] = $url_cidade;
		$dados['url_bairro'] = $url_bairro;
		$dados['url_dormitorios'] = $url_dormitorios;
		$dados['url_suites'] = $url_suites;
		$dados['url_valor_maximo'] = $url_valor_maximo;
		$dados['url_valor_maximo_tratado'] = $valores->trata_valor($url_valor_maximo);
		$dados['url_valor_maximo_tratado_busca'] = trata_valor_busca($url_valor_maximo);
		$dados['url_valor_minimo'] = $url_valor_minimo;
		$dados['url_valor_minimo_tratado'] = $valores->trata_valor($url_valor_minimo);
		$dados['url_valor_minimo_tratado_busca'] = trata_valor_busca($url_valor_minimo);
		$dados['url_ordem'] = $url_ordem;
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar($query);
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $this->limita_texto($data->titulo, 30);
			$lista[$i]['valor'] = $valores->trata_valor($data->valor);
			$lista[$i]['cidade'] = $data->cidade; 
			$lista[$i]['bairro'] = $data->bairro;
			$lista[$i]['uf'] = $data->uf;

			$lista[$i]['tipo_titulo'] = $data->tipo_titulo;
			$lista[$i]['categoria_titulo'] = $data->categoria_titulo;
			$lista[$i]['ref'] = $data->ref;
			
			if($data->status == 1){
				$lista[$i]['status'] = 'Ativo';
			} else {
				$lista[$i]['status'] = 'Inativo';
			}

			$imagens = $imoveis->imagens($data->codigo);
			if(isset($imagens[0]['imagem_g'])){
				$lista[$i]['imagem_principal'] = $imagens[0]['imagem_g'];
			} else {
				$lista[$i]['imagem_principal'] = LAYOUT."img/semimagem.png.png";
			}

			$lista[$i]['endereco'] = DOMINIO."imoveis/detalhes/id/".$data->id."/item/".$imoveis->trata_url_titulo($data->titulo);

			$i++;
		}
		
		$dados['lista_imoveis'] = $lista;

		$dados['tipos'] = $imoveis->tipos();
		$dados['cidades'] = $imoveis->cidades();

		//carrega view e envia dados para a tela
		$this->view('imoveis', $dados);
	}

	public function detalhes(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;

		$id = $this->get('id');
		if(!$id){
			$this->irpara(DOMINIO."erro");
		}

		$conexao = new mysql();
		$coisas_imovel = $conexao->Executar("SELECT * FROM imoveis where id='$id' ");
		$dados['data'] = $coisas_imovel->fetch_object();

		if( !$dados['data']->id ){
			$this->irpara(DOMINIO."erro");
		}

		$imoveis = new model_imoveis();
		$dados['imagens'] = $imoveis->imagens($dados['data']->codigo);
		if(isset($dados['imagens'][0]['imagem_g'])){
			$dados['imagem_principal'] = $dados['imagens'][0]['imagem_g'];
		}

		$dados['endereco_postagem'] = DOMINIO.'imoveis/detalhes/id/'.$dados['data']->id;

		$valores = new model_valores();
		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['iptu'] = $valores->trata_valor($dados['data']->iptu);
		$dados['condominio'] = $valores->trata_valor($dados['data']->condominio);	
		$dados['similares'] = $imoveis->similares($dados['data']->codigo, $dados['data']->categoria_id, $dados['data']->tipo_id);
		
		//carrega view e envia dados para a tela
		$this->view('imoveis.detalhes', $dados);
	}

	public function bairros(){

		$cidade = $this->post('cidade');

		if($cidade){

			echo "
			<select class='selectpicker' name='bairro' id='bairro' onChange=\"numero_imoveis();\" >
			<option value='bairro' selected >Todos</option>
			";

			$db = new mysql();
			$exec = $db->executar("SELECT bairro FROM imoveis_bairros WHERE cidade='$cidade' order by bairro asc");
			while($data = $exec->fetch_object()) {
				echo "<option value='".$data->bairro."' >".$data->bairro."</option>";
			}

			echo "
			</select>
			";

			echo "
			<script>
			$('.selectpicker').selectpicker();
			</script>
			";

			exit;

		} else {

			echo "
			<select class='selectpicker' name='bairro' id='bairro' >
			<option value='bairro' selected >Todos</option>
			</select>
			";

			echo "
			<script>
			$('.selectpicker').selectpicker();
			</script>
			";

			exit;
		}

	}

	public function bairros_principal(){

		$cidade = $this->post('cidade');

		if($cidade){

			echo "
			<select class='selectpicker' data-live-search='true' name='bairro' id='bairro_principal' onChange=\"numero_imoveis();\" >
			<option value='bairro' selected='' >Todos</option>
			";

			$db = new mysql();
			$exec = $db->executar("SELECT bairro FROM imoveis_bairros WHERE cidade='$cidade' order by bairro asc");
			while($data = $exec->fetch_object()) {
				echo "<option value='".$data->bairro."' >".$data->bairro."</option>";
			}

			echo "
			</select>
			";

			echo "
			<script>
			$('.selectpicker').selectpicker();
			</script>
			";

			exit;

		} else {

			echo "
			<select class='selectpicker' name='bairro' id='bairro_principal' onChange=\"numero_imoveis();\" >
			<option value='bairro' selected >Todos</option>
			</select>
			";

			echo "
			<script>
			$('.selectpicker').selectpicker();
			</script>
			";

			exit;

		}

	}

}