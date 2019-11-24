<?php

Class model_imoveis extends model{


	public function lista(){

		$valores = new model_valores();
		$lista = array();
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE add_ok='1' order by titulo asc");
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
	
	public function lista_cidades($codigo = null){

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
	
	public function lista_bairros($cidade, $estado){

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

	public function lista_bairros_all(){

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
	
	public function lista_tipos($codigo = null){

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
	
	public function lista_categorias($codigo = null){

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

	public function lista_imagens($codigo){

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

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function adiciona_imagem($vars){ 

		$db = new mysql();
		$db->inserir("imoveis_imagem", array(
			"codigo"	=>$vars[0],
			"imagem"	=>$vars[1]
		));
		$ultid = $db->ultimo_id();
		
		return $ultid;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function ordem_imagens($codigo){

		$conexao = new mysql();
		$coisas_ordem = $conexao->Executar("SELECT * FROM imoveis_imagem_ordem WHERE codigo='$codigo' ORDER BY id desc limit 1");
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
		$db->inserir("imoveis_imagem_ordem", array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));
		
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function seleciona_imagem($id){		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
		return $exec->fetch_object();
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	// MASCARA IMAGEM

	public function carrega_mascara(){
		
		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();
		return $data_masc->codigo;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	//

	public function altera_mascara($codigo){
		
		$db = new mysql();
		$db->alterar("imoveis_marcadagua", array(			 
			"codigo"	=>$codigo
		), " id='1' " );

	}

}