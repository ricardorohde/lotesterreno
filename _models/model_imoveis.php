<?php

Class model_imoveis extends model{

	public function lista(){

		$valores = new model_valores();
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE status='1' AND add_ok='1' order by titulo asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['titulo'] = $data->titulo;
			$lista[$i]['valor'] = $valores->trata_valor($data->valor);
			$lista[$i]['categoria_titulo'] = $data->categoria_titulo;
			$lista[$i]['tipo_titulo'] = $data->tipo_titulo;
			$lista[$i]['ref'] = $data->ref;
			
			if($data->status == 1){
				$lista[$i]['status'] = 'Ativo';
			} else {
				$lista[$i]['status'] = 'Inativo';
			}
			
			$i++;
		}
		
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function destaques($tipo){
		
		$valores = new model_valores();
		
		if($tipo == 'locacao'){
			$categoria_id = '5280';
		} else {
			$categoria_id = '5279';
		}

		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE add_ok='1' AND categoria_id='$categoria_id' AND destaque='1' AND status='1' order by codigo desc limit 9");
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

			$imagens = $this->imagens($data->codigo);
			if(isset($imagens[0]['imagem_g'])){
				$lista[$i]['imagem_principal'] = $imagens[0]['imagem_g'];
			} else {
				$lista[$i]['imagem_principal'] = LAYOUT."img/semimagem.png.png";
			}

			$lista[$i]['endereco'] = DOMINIO."imoveis/detalhes/id/".$data->id."/item/".$this->trata_url_titulo($data->titulo);

			$i++;
		}
		
		return $lista;
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function similares($codigo, $categoria_id, $tipo_id){
		
		$valores = new model_valores();
		
		$lista = array();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE status='1' AND add_ok='1' AND categoria_id='$categoria_id' AND tipo_id='$tipo_id' AND codigo!='$codigo' order by codigo desc limit 9");
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

			$imagens = $this->imagens($data->codigo);
			if(isset($imagens[0]['imagem_g'])){
				$lista[$i]['imagem_principal'] = $imagens[0]['imagem_g'];
			} else {
				$lista[$i]['imagem_principal'] = LAYOUT."img/semimagem.png.png";
			}

			$lista[$i]['endereco'] = DOMINIO."imoveis/detalhes/id/".$data->id."/item/".$this->trata_url_titulo($data->titulo);

			$i++;
		}
		
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function cidades($codigo = null){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_cidades order by cidade asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;

			if($codigo == $data->codigo){
				$lista[$i]['selected'] = true;
			} else {
				$lista[$i]['selected'] = false;
			}

			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function bairros($cidade, $estado){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_bairros WHERE cidade='$cidade' AND estado='$estado' order by bairro asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['bairro'] = $data->bairro;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			$i++;
		}

		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function bairros_all(){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_bairros order by bairro asc");
		$i = 0;
		while($data = $exec->fetch_object()) {
			
			$lista[$i]['id'] = $data->id;
			$lista[$i]['codigo'] = $data->codigo;
			$lista[$i]['bairro'] = $data->bairro;
			$lista[$i]['cidade'] = $data->cidade;
			$lista[$i]['estado'] = $data->estado;
			
			$i++;
		}
		
		return $lista;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function tipos($codigo = null){
		
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_tipos order by titulo asc");
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

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	
	public function categorias($codigo = null){

		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_categorias order by titulo asc");
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
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// IMAGENS
	
	public function imagens($codigo){
		
		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM imoveis_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
		$data_ordem = $coisas_ordem->fetch_object();
		
		$n = 0;
		$dados = array();
		$imagens = array();
		if(isset($data_ordem->data)){
			
			$order = explode(',', $data_ordem->data); 
			
			foreach($order as $key => $value){
				
				$conexao = new mysql();
				$coisas_img = $conexao->Executar("SELECT * FROM imoveis_imagem WHERE id='$value'");
				$data_img = $coisas_img->fetch_object();                                
				
				if(isset($data_img->imagem)){
					
					if($n == 0){
						$dados['principal'] = PASTA_CLIENTE.'img_imoveis_g/'.$codigo.'/'.$data_img->imagem;
					}
					
					$imagens[$n]['id'] = $data_img->id;
					$imagens[$n]['imagem'] = $data_img->imagem;
					$imagens[$n]['imagem_p'] = PASTA_CLIENTE.'img_imoveis_p/'.$codigo.'/'.$data_img->imagem;
					$imagens[$n]['imagem_g'] = PASTA_CLIENTE.'img_imoveis_g/'.$codigo.'/'.$data_img->imagem;
					
					$n++;
				}
			}
		}

		return $imagens;
	}

	protected function limita_texto($var, $limite){
		if (strlen($var) > $limite)	{
			$var = substr($var, 0, $limite);
			$var = trim($var) . "...";
		}		
		return $var;
	}

	//trata nome para url
	public function trata_url_titulo($titulo){

		//remove acentos
		$titulo_tratado = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $titulo);

		//remove caracteres indesejados
		$titulo_tratado = str_replace(array("?", ",", ".", "+", "'", "/", ")", "(", "&", "%", "#", "@", "!", "=", ">", "<", ";", ":", "|", "*", "$"), "", $titulo_tratado);
		//coloca ifen para separar palavras
		$titulo_tratado = str_replace(array(" ", "_", "+"), "-", $titulo_tratado);
		//certifica que não tem ifens repetidos
		$titulo_tratado = preg_replace('/(.)\1+/', '$1', $titulo_tratado);		 

		return $titulo_tratado;
	}
	
}