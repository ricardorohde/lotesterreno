<?php

class imoveis extends controller {
	
	protected $_modulo_nome = "Imóveis";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(92);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		// instancia
		$imoveis = new model_imoveis();
		
		$dados['lista'] = $imoveis->lista();
		
		$this->view('imoveis', $dados);
	}
	
	public function novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$dados['aba_selecionada'] = "dados";

		if($this->get('cadastro')){
			$dados['cod_cadastro'] = $this->get('cadastro');
		} else {
			$dados['cod_cadastro'] = 0;
		}

		$this->view('imoveis.novo', $dados);
	}

	public function novo_grv(){
		
		$fotos = $this->get('fotos');
		$cadastro = $this->get('cadastro');

		$db = new mysql();
		$exec = $db->executar("SELECT codigo, add_ok FROM imoveis order by id desc limit 1");
		$data = $exec->fetch_object();

		if( ($exec->num_rows == 0) OR ($data->add_ok == 1) ){
			
			$codigo = $this->gera_codigo();

			$db = new mysql();
			$db->inserir("imoveis", array(
				"codigo"=>"$codigo", 
				"titulo"=>"Novo Imóvel"
			));
			
		} else {
			$codigo = $data->codigo;
		}

		if($fotos == 1){
			$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem/cadastro/'.$cadastro); 
		} else {
			$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/dados/cadastro/'.$cadastro);
		}

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

		$dados['cadastro_get'] = $this->get('cadastro');
		
 		// instancia
		$imoveis = new model_imoveis();
		$valores = new model_valores();		

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		$dados['valor'] = $valores->trata_valor($dados['data']->valor);
		$dados['condominio'] = $valores->trata_valor($dados['data']->condominio);
		$dados['iptu'] = $valores->trata_valor($dados['data']->iptu);

 		//imagens
		$dados['imagens'] = $imoveis->lista_imagens($dados['data']->codigo);

		// categorias
		$dados['categorias'] = $imoveis->lista_categorias($dados['data']->categoria_id);

		//cidades
		$dados['cidades'] = $imoveis->lista_cidades($dados['data']->cidade_id);

 		// tipos
		$dados['tipos'] = $imoveis->lista_tipos($dados['data']->tipo_id);
		
		// cadastros
		$cadastro = new model_cadastros();
		$dados['lista_cadastro'] = $cadastro->lista();

		$this->view('imoveis.alterar', $dados);
	}
	
	public function alterar_dados(){

		// instancia
		$imoveis = new model_imoveis();
		$valores = new model_valores();
		
		$codigo = $this->post('codigo');
		$cadastro = $this->post('cadastro');
		
		$titulo = $this->post('titulo');
		$ref = $this->post('ref');	

		$valor = $this->post('valor');
		$valor_formatado = $valores->trata_valor_banco($valor);

		$condominio = $this->post('condominio');
		$condominio_formatado = $valores->trata_valor_banco($condominio);

		$iptu = $this->post('iptu');
		$iptu_formatado = $valores->trata_valor_banco($iptu);

		$descricao = $_POST['descricao'];

		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo'); 
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');	
		$endereco = $this->post('endereco');
		$numero  = $this->post('numero');
		$complemento  = $this->post('complemento');
		$cep  = $this->post('cep');
		
		$area_util = $this->post('area_util');
		$area_total  = $this->post('area_total');
		$garagem  = $this->post('garagem');
		$churrasqueira  = $this->post('churrasqueira');

		$quartos = $this->post('quartos');
		$suites  = $this->post('suites');
		$banheiros  = $this->post('banheiros');

		$destaque = $this->post('destaque');
		$status = $this->post('status');
		
 	
		$this->valida($codigo); 
		
		$time = time();

		// categoria
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_categorias WHERE codigo='$categoria' ");
		$data = $coisas->fetch_object();
		
		$categoria_titulo = $data->titulo;

		// tipo
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT titulo FROM imoveis_tipos WHERE codigo='$tipo' ");
		$data = $coisas->fetch_object();

		$tipo_titulo = $data->titulo;

		// bairro
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT bairro FROM imoveis_bairros WHERE codigo='$bairro' ");
		$data = $coisas->fetch_object();

		$bairro_titulo = $data->bairro;
		
		// cidade
		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		$cidade_nome = $data->cidade;
		$uf = $data->estado;


		// grava no banco

		$db = new mysql();
		$db->alterar("imoveis", array(
			"cadastro"=>"$cadastro",
			"data_alteracao"=>"$time",
			"titulo"=>"$titulo",
			"ref"=>"$ref",
			"categoria_id"=>"$categoria",
			"categoria_titulo"=>"$categoria_titulo	",
			"tipo_id"=>"$tipo",
			"tipo_titulo"=>"$tipo_titulo",
			"descricao"=>"$descricao",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro_id"=>"$bairro",
			"bairro"=>"$bairro_titulo",
			"cidade_id"=>"$cidade",
			"cidade"=>"$cidade_nome",
			"uf"=>"$uf",
			"cep"=>"$cep",
			"valor"=>"$valor_formatado",
			"area_util"=>"$area_util",
			"area_total"=>"$area_total",
			"iptu"=>"$iptu_formatado",
			"condominio	"=>"$condominio_formatado",
			"quartos"=>"$quartos",
			"suites"=>"$suites",
			"garagem"=>"$garagem",
			"banheiros"=>"$banheiros",
			"churrasqueira"=>"$churrasqueira",
			"destaque"=>"$destaque",
			"status"=>"$status",
			"add_ok"=>"1"
		), " codigo='$codigo' ");


		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/dados');
	}

	public function lista_bairros(){

		$dados['_base'] = $this->base();

		$cidade = $this->post('cidade');
		$selecionado = $this->post('selecionado');

		if($cidade){

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
			$data = $coisas->fetch_object();

			if($data->cidade AND $data->estado){

				$imoveis = new model_imoveis();
				$listadebairros = $imoveis->lista_bairros($data->cidade, $data->estado);
				
				echo "
				<select class='form-control select2' name='bairro' >
				<option value='' >Selecione</option>
				";

				foreach ($listadebairros as $key => $value) {

					if($value['codigo'] == $selecionado){
						$selected = " selected='' ";
					} else {
						$selected = "";
					}

					echo "<option value='".$value['codigo']."' $selected >".$value['bairro']."</option>";
				}

				echo "</select>";

			} else {
				echo "erro";
			}			
		} else {
			echo "erro";
		}

	}

	public function apagar_varios(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista() as $key => $value) {			
			if($this->post('apagar_'.$value['id']) == 1){				 

				foreach ($imoveis->lista_imagens($value['codigo']) as $key3 => $value3) {

					if( $value3['imagem'] ){
						unlink('arquivos/img_imoveis_g/'.$value['codigo'].'/'.$value3['imagem']);
						unlink('arquivos/img_imoveis_p/'.$value['codigo'].'/'.$value3['imagem']);						 
					}

				}

				$db = new mysql();
				$db->apagar("imoveis", " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar("imoveis_imagem", " codigo='".$value['codigo']."' ");

				$db = new mysql();
				$db->apagar("imoveis_imagem_ordem", " codigo='".$value['codigo']."' ");

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
		$pasta = "imoveis";
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
		$imoveis = new model_imoveis();

		// Recuperando imagem em base64
		// Exemplo: data:image/png;base64, 
		$imagem = $_POST['imagem'];
		$nome_original = $this->post('nomeimagem');

		$nome_foto  = $img->trata_nome($nome_original);
		$extensao = $img->extensao($nome_original);

		// Separando tipo dos dados da imagem
		// $tipo: data:image/png
		// $dados: base64, 
		list($tipo, $dados) = explode(';', $imagem);

		// Isolando apenas o tipo da imagem
		// $tipo: image/png
		list(, $tipo) = explode(':', $tipo);

		// Isolando apenas os dados da imagem
		// $dados:  
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
				$largura_g = 1200;
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
			$cod_mascara = $imoveis->carrega_mascara();				
			if($cod_mascara){
				$mascara = new model_mascara();
				$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
			}

			//grava banco e retorna id
			$ultid = $imoveis->adiciona_imagem(array(
				$codigo,
				$nome_foto
			));

			//ordem
			$ordem = $imoveis->ordem_imagens($codigo);								
			if($ordem){
				$novaordem = $ordem.",".$ultid;
			} else {
				$novaordem = $ultid;
			}
			// grava ordem
			$imoveis->salva_ordem_imagem($codigo, $novaordem);

			$db = new mysql();
			$db->alterar("imoveis", array(
				"add_ok"=>"1"
			), " codigo='$codigo' ");

		}

	}

	public function imagem_manual(){

		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');

		$nome_original = $_FILES['arquivo']['name'];

		//definições de pasta
		$pasta = "imoveis";
		$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo."/";

		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}

		$img = new model_arquivos_imagens();
		$imoveis = new model_imoveis();

		if($tmp_name) {

			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);

			if(copy($tmp_name, $diretorio_g.$nome_foto)){

				//confere e se jpg reduz a miniatura
				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					// foto grande
					$largura_g = 1200;
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
				$cod_mascara = $imoveis->carrega_mascara();				
				if($cod_mascara){
					$mascara = new model_mascara();
					$mascara->aplicar($cod_mascara, $diretorio_g.$nome_foto);
				}

				//grava banco e retorna id
				$ultid = $imoveis->adiciona_imagem(array(
					$codigo,
					$nome_foto
				));

				//ordem
				$ordem = $imoveis->ordem_imagens($codigo);								
				if($ordem){
					$novaordem = $ordem.",".$ultid;
				} else {
					$novaordem = $ultid;
				}

				// grava ordem
				$imoveis->salva_ordem_imagem($codigo, $novaordem);

				$db = new mysql();
				$db->alterar("imoveis", array(
					"add_ok"=>"1"
				), " codigo='$codigo' ");

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}

	}

	public function ordenar_imagem(){

		$codigo = $this->post('codigo');
		$list = $this->post('list');

		$this->valida($codigo);
		$this->valida($list);

		// instancia
		$imoveis = new model_imoveis();

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		//grava
		$imoveis->salva_ordem_imagem($codigo, $ordem);
	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
			$data = $exec->fetch_object();

			//imagem
			if($data->imagem){
				unlink('arquivos/img_imoveis_g/'.$data->codigo.'/'.$data->imagem);
				unlink('arquivos/img_imoveis_p/'.$data->codigo.'/'.$data->imagem);
			}
			//apaga
			$db = new mysql();
			$db->apagar("imoveis_imagem", " id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}

	public function girar_imagem(){

		$codigo = $this->get('codigo');
		$id = $this->get('id');

		$imoveis = new model_imoveis();
		$arquivos = new model_arquivos_imagens();

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM imoveis_imagem WHERE id='$id' ");
		$data = $exec->fetch_object();

		$nome_antigo = $data->imagem;

		$extensao = $arquivos->extensao($data->imagem);
		$novo_nome = substr($nome_antigo, 0, strlen($nome_antigo) - 25).'.'.$extensao;
		$novo_nome_tratado = $arquivos->trata_nome($novo_nome);

		$caminho = "arquivos/img_imoveis_g/".$codigo."/".$nome_antigo;
		// destino
		$destino = "arquivos/img_imoveis_g/".$codigo."/".$novo_nome_tratado;

		// gira a imagem
		if($arquivos->girar_imagem($caminho, $destino)){

			///////////////////////////////
			// imagem pequena

			$caminho = "arquivos/img_imoveis_p/".$codigo."/".$nome_antigo;
			// destino
			$destino = "arquivos/img_imoveis_p/".$codigo."/".$novo_nome_tratado;

			// gira a imagem
			if($arquivos->girar_imagem($caminho, $destino)){

				// remove imagem antiga
				unlink("arquivos/img_imoveis_g/".$codigo."/".$nome_antigo);
				unlink("arquivos/img_imoveis_p/".$codigo."/".$nome_antigo);
				
				// grava nova imagem
				$db = new mysql();
				$db->alterar("imoveis_imagem", array(
					"imagem"=>"$novo_nome_tratado"
				), " id='$id' ");
				
				// direciona
				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
				
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
		$imoveis = new model_imoveis();

		$mascara = $imoveis->carrega_mascara();
		$dados['lista'] = $mascaras->lista($mascara);

		$this->view('imoveis.mascara', $dados);
	}	

	public function mascara_grv(){

		$codigo = $this->post('codigo');

		$imoveis = new model_imoveis();
		$imoveis->altera_mascara($codigo);

		$this->irpara(DOMINIO.$this->_controller.'/mascara');
	}




///////////////////////////////////////////////////////////////////////////////////////


	public function cidades(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Cidades";

		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_cidades();		

		$this->view('imoveis.cidades', $dados);
	}

	public function cidades_nova(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Criar Cidade";

		$this->view('imoveis.cidades.nova', $dados);
	}

	public function cidades_nova_grv(){

		$cidade = $this->post('cidade');
		$estado = $this->post('estado');

		$this->valida($cidade);
		$this->valida($estado);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("imoveis_cidades", array(
			"codigo"=>"$codigo",
			"cidade"=>"$cidade",
			"estado"=>"$estado"
		));

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}

	public function cidades_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Cidade";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar cidade!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.cidades.alterar', $dados);
	}

	public function cidades_alterar_grv(){

		$codigo = $this->post('codigo');
		$cidade = $this->post('cidade');
		$estado = $this->post('estado');

		$this->valida($codigo);
		$this->valida($cidade);
		$this->valida($estado);

		$db = new mysql();
		$db->alterar("imoveis_cidades", array(
			"cidade"=>"$cidade",
			"estado"=>"$estado"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}

	public function cidades_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_cidades() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_cidades", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/cidades');		
	}


///////////////////////////////////////////////////////////////////////////////////////


	public function bairros(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Bairros";

// Instancia
		$imoveis = new model_imoveis();

		$cidade = $this->get('cidade');

		$dados['cidades'] = $imoveis->lista_cidades();
		if(!$cidade){
			$cidade = $dados['cidades'][0]['codigo'];
		}
		$dados['selecionado'] = $cidade;

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		$dados['lista'] = $imoveis->lista_bairros($data->cidade, $data->estado);

		$this->view('imoveis.bairros', $dados);
	}

	public function bairros_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Criar Bairro";

// Instancia
		$imoveis = new model_imoveis();
		$dados['cidades'] = $imoveis->lista_cidades();

		$this->view('imoveis.bairros.novo', $dados);
	}

	public function bairros_novo_grv(){

		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		$this->valida($cidade);
		$this->valida($bairro);

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		if($data->cidade AND $data->estado){

			$codigo = $this->gera_codigo();

			$db = new mysql();
			$db->inserir("imoveis_bairros", array(
				"codigo"=>$codigo,
				"bairro"=>$bairro,
				"cidade"=>$data->cidade,
				"estado"=>$data->estado
			));

		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros/cidade/'.$cidade);
	}

	public function bairros_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar Bairro";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar bairro!');
			$this->volta(1);
		}

// Instancia
		$imoveis = new model_imoveis();
		$dados['cidades'] = $imoveis->lista_cidades();

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_bairros WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.bairros.alterar', $dados);
	}

	public function bairros_alterar_grv(){

		$codigo = $this->post('codigo');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');

		$this->valida($codigo);
		$this->valida($cidade);
		$this->valida($bairro);

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_cidades WHERE codigo='$cidade' ");
		$data = $coisas->fetch_object();

		if($data->cidade AND $data->estado){

			$db = new mysql();
			$db->alterar("imoveis_bairros", array(
				"bairro"=>$bairro,
				"cidade"=>$data->cidade,
				"estado"=>$data->estado
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros/cidade/'.$cidade);
	}

	public function bairros_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_bairros_all() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_bairros", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/bairros');		
	}

///////////////////////////////////////////////////////////////////////////////////////


	public function tipos(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Tipos";

// Instancia
		$imoveis = new model_imoveis();

		$dados['lista'] = $imoveis->lista_tipos();		

		$this->view('imoveis.tipos', $dados);
	}

	public function tipos_novo(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Novo";

		$this->view('imoveis.tipos.novo', $dados);
	}

	public function tipos_novo_grv(){

		$titulo = $this->post('titulo'); 

		$this->valida($titulo);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("imoveis_tipos", array(
			"codigo"=>"$codigo", 
			"titulo"=>"$titulo"
		));

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}

	public function tipos_alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

		if(!$codigo){
			$this->msg('Erro ao identificar o tipo!');
			$this->volta(1);
		}

		$conexao = new mysql();
		$coisas = $conexao->Executar("SELECT * FROM imoveis_tipos WHERE codigo='$codigo' ");
		$dados['data'] = $coisas->fetch_object();

		$this->view('imoveis.tipos.alterar', $dados);
	}

	public function tipos_alterar_grv(){

		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');

		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("imoveis_tipos", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}

	public function tipos_apagar(){

		$imoveis = new model_imoveis();

		foreach ($imoveis->lista_tipos() as $key => $value) {

			if($this->post('apagar_'.$value['id']) == 1){

				$db = new mysql();
				$db->apagar("imoveis_tipos", " id='".$value['id']."' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/tipos');		
	}

///////////////////////////////////////////////////////////////////////////////////////

}