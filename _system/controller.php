<?php

class controller extends system {
	
	protected $_sessao = false;
	
	protected function _base(){

		$dados = array();
		$dados['libera_views'] = true;
		
		//detecta navegador 
		$navegador = new model_navegador();
		$dados['navegador'] = $navegador->nome();
		
		//informações basicas de metan
		$db = new mysql();
		$config = $db->executar("select * from meta where id='1' ")->fetch_object();
		$dados['titulo_pagina'] = $config->titulo_pagina;
		$dados['descricao'] = $config->descricao;
		
		//imagens fixas
		$imagem = new model_imagem();
		$dados['favicon'] = $imagem->codigo('147193111415927');
		$dados['logo'] = $imagem->codigo('147796771992551');
		
		//carrega imagens do setadas no painel de controle
		$db = new mysql();
		$exec = $db->executar("select codigo, imagem from imagem ");
		while($data = $exec->fetch_object()){
			if($data->imagem){
				$dados['imagem'][$data->codigo] = PASTA_CLIENTE.'imagens/'.$data->imagem;
			} else {
				$dados['imagem'][$data->codigo] = '';
			}
		}
		
		// cores
		$cores = new model_cores();
		$dados['cor']  = $cores->lista();
		
		// redes sociais
		$redessociais = new model_redes_sociais(); 
		$dados['redessociais'] = $redessociais->lista();		
		$dados['facebook'] = "";
		foreach ($dados['redessociais'] as $key => $value) {
			if(
				($value['titulo'] == 'facebook') OR 
				($value['titulo'] == "Facebook")
			){
				$dados['facebook'] = $value['endereco'];		
			}
		}

		//textos
		$textos = new model_textos();
		$dados['topo_fone'] = $textos->conteudo('154472085623402');
		$dados['slogan'] = $textos->conteudo('154472161076641');
		$dados['rodape_endereco1'] = $textos->conteudo('154474505229929');
		$dados['rodape_endereco2'] = $textos->conteudo('154474514077654');
		$dados['rodape_endereco3'] = $textos->conteudo('154474517525587');
		
		$dados['rodape_telefone1'] = $textos->conteudo('154474571539640');
		$dados['rodape_telefone2'] = $textos->conteudo('154474577677620');
		
		$menu = new model_menu();
		$dados['menu'] = $menu->lista();
		$dados['menu_rodape'] = $menu->lista_rodape();
		
		//retorna para a pagina a array com todos as informações
		return $dados;
	}

	//carrega o html 
	protected function view( $arquivo, $vars = null ){

		if( is_array($vars) && count($vars) > 0){
			//transforma array em variavel
			//com prefixo
			//extract($vars, EXTR_PREFIX_ALL, 'htm_');
			//se ouver variaveis iguais adiciona prefixo
			extract($vars, EXTR_PREFIX_SAME, 'htm_');
		}

		$url_view = VIEWS."htm_".$arquivo.".php";

		if(!file_exists($url_view)){
			$this->erro();
		} else {
			return require_once($url_view);
		}

	}

	// limita texto para previas
	protected function limita_texto($var, $limite){
		if (strlen($var) > $limite)	{
			$var = substr($var, 0, $limite);
			$var = trim($var) . "...";
		}		
		return $var;
	}

	//gera codigo que nunca se repete
	protected function gera_codigo(){
		return substr(time().rand(10000,99999),-15);
	}

	//confere se foi preenchido um campo post ou get
	protected function valida($var, $msg = null){
		if(!$var){
			if($msg){
				$this->msg($msg);
				$this->volta(1);
			} else {
				$this->msg('Preencha todos os campos e tente novamente!');
				$this->volta(1);
			}
		}
	}

}