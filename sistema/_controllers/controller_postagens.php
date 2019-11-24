<?php

class postagens extends controller {
	
	protected $_modulo_nome = "Postagens";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(27);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$dados['acesso_mascara'] = true;
		$dados['acesso_destaques'] = true;
		$dados['acesso_categorias'] = true;
		$dados['acesso_autores'] = true;
		

		//grupo selecionado
		$grupo = $this->get('grupo');
		$dados['grupo'] = $grupo;
		
		//lista categorias
		$postagens = new model_postagens();
		$dados['categorias'] = $postagens->grupos($grupo);

		//noticias
		if($grupo){
			$postagens->categoria = $grupo; //itens por pagina
		}
		$postagens->ordem = 'desc';
		$postagens_retorno = $postagens->lista();
		$dados['noticias'] = $postagens_retorno['noticias'];
		
		$this->view('postagens', $dados);
	}
	

	public function nova(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Novo";

 		$dados['aba_selecionada'] = "dados";

 		$dados['hora'] = date('H', time());
 		$dados['minuto'] = date('i', time());
 		$dados['dia'] = date('d', time());
 		$dados['mes'] = date('m', time());
 		$dados['ano'] = date('Y', time());

 		$grupo = $this->get('grupo');
 		$dados['grupo'] = $grupo;
 		 		 
 		//lista categorias
		$postagens = new model_postagens();
		$dados['categorias'] = $postagens->grupos($grupo);
		$dados['autores'] = $postagens->autores();
		$dados['destaques'] = $postagens->destaques();

		$this->view('postagens.nova', $dados);
	}


	public function nova_grv(){
		
		$titulo = $this->post('titulo');
		$autor = $this->post('autor');
		$previa = $this->post('previa');
		$conteudo = $_POST['conteudo'];
		$categoria = $this->post('grupo');
		$destaque = $this->post('destaque');

		$hora = $this->post('hora');
		$dia = $this->post('dia');
		
		$arraydata = explode("/", $dia);
		
		$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." ".$hora.":00";
		$data_final = strtotime($hora_montada);

		$this->valida($titulo);
		$this->valida($categoria);

		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia", array(
			"codigo"=>"$codigo",
			"categoria"=>"$categoria",
			"data"=>"$data_final",
			"titulo"=>"$titulo",
			"autor"=>"$autor",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo",
			"destaque"=>"$destaque"
		));
	 	
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

 		$db = new mysql();
 		$exec = $db->Executar("SELECT * FROM noticia where codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();
		
 		$dados['hora'] = date('H', $dados['data']->data);
 		$dados['minuto'] = date('i', $dados['data']->data);
 		$dados['dia'] = date('d', $dados['data']->data);
 		$dados['mes'] = date('m', $dados['data']->data);
 		$dados['ano'] = date('Y', $dados['data']->data);

 		//categorias
 		$postagens = new model_postagens();
 		$dados['categorias'] = $postagens->grupos($dados['data']->categoria);
 		$dados['autores'] = $postagens->autores($dados['data']->autor);
 		$dados['destaques'] = $postagens->destaques($dados['data']->destaque);
 		$dados['audios'] = $postagens->audios($dados['data']->codigo);

 		//imagens
 		$imagens = $postagens->imagens($dados['data']->codigo);
        $dados['imagens'] = $imagens['lista'];
		

		$this->view('postagens.alterar', $dados);
	}


	public function alterar_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');
		$autor = $this->post('autor');
		$previa = $this->post('previa');
		$conteudo = $_POST['conteudo'];
		$categoria = $this->post('grupo');
		$destaque = $this->post('destaque');

		$hora = $this->post('hora');
		$dia = $this->post('dia');
		
		$arraydata = explode("/", $dia);
		
		$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." ".$hora.":00";
		$data_final = strtotime($hora_montada);

		$this->valida($titulo);
		$this->valida($categoria);

		$db = new mysql();
		$db->alterar("noticia", array(
			"categoria"=>"$categoria",
			"data"=>"$data_final",
			"titulo"=>"$titulo",
			"autor"=>"$autor",
			"previa"=>"$previa",
			"conteudo"=>"$conteudo",
			"destaque"=>"$destaque"
		), " codigo='$codigo' ");
	 	

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);		
	}


	public function apagar_imagem(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_imagem where id='$id' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('arquivos/img_postagens_g/'.$codigo.'/'.$data->imagem);
				unlink('arquivos/img_postagens_p/'.$codigo.'/'.$data->imagem);
			}

			$conexao = new mysql();
			$conexao->apagar("noticia_imagem", " id='$id' ");
		}
		
		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}


	public function ordenar_imagem(){

		$codigo = $this->post('codigo');
		$list = $this->post('list');
		
		$this->valida($codigo);
		$this->valida($list);

		$output = array();
		parse_str($list, $output);
		$ordem = implode(',', $output['item']);

		$db = new mysql();
		$db->inserir("noticia_imagem_ordem", array(
			"codigo"=>"$codigo",
			"data"=>"$ordem"
		));

	}


	public function legenda(){

		$dados['_base'] = $this->base();

		$id = $this->get('id');
		$codigo = $this->get('codigo');

		$dados['codigo'] = $codigo;
		$dados['id'] = $id;

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$dados['legenda'] = $data->legenda;
		} else {
			$dados['legenda'] = '';
		}

		$this->view('postagens.legenda', $dados);
	}


	public function legenda_grv(){

		$id = $this->post('id');
		$legenda = $this->post('legenda');
		$codigo = $this->post('codigo');

		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_imagem_legenda where id_img='$id' ");
		$data = $exec->fetch_object();

		if(isset($data->id)){
			$db = new mysql();
			$db->alterar("noticia_imagem_legenda", array(
				"legenda"=>"$legenda"
			), " id='$data->id' ");
		} else {
			$db = new mysql();
			$db->inserir("noticia_imagem_legenda", array(
				"id_img"=>"$id",
				"legenda"=>"$legenda"
			));
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/imagem');
	}


 	public function novo_audio(){
 		
 		$codigo = $this->get('codigo');
 		$titulo = $this->post('titulo');

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$this->valida($titulo);
		$this->valida($codigo);

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		//// Definicao de Diretorios / 
		$diretorio = "arquivos/audios/$codigo/";

		//confere e cria pasta se necessario
		if(!is_dir($diretorio)) {
			mkdir($diretorio);
		}
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
			
			$nome_original = $_FILES['arquivo']['name'];
			$nome_arquivo  = $arquivo->trata_nome($nome_original);
			
			$destino = $diretorio.$nome_arquivo;
			
			if(copy($tmp_name, $destino)){

				// Grava informações no banco
				$conexao = new mysql();
				$conexao->inserir("noticia_audio", array(
					"codigo"=>"$codigo",
					"arquivo"=>"$nome_arquivo",
					"titulo"=>"$titulo"
				));

				$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/audios');

			} else {
				$this->msg('Não foi possível copiar o arquivo!');
				$this->volta(1);
			}

		}
 	}


 	public function apagar_audio(){
		
		$codigo = $this->get('codigo');
		$id = $this->get('id');

		if($id){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_audio where id='$id' ");
			$data = $exec->fetch_object();

			if(isset($data->arquivo)){
				unlink('arquivos/audios/'.$codigo.'/'.$data->arquivo);
			}

			$conexao = new mysql();
			$conexao->apagar("noticia_audio", " id='$id' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo.'/aba/audios');
	}


	public function apagar_varios(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){

				$db = new mysql();
				$exec_audio = $db->executar("SELECT * FROM noticia_audio where codigo='$data->codigo' ");
				while($data_audio = $exec_audio->fetch_object()){
					
					if(isset($data_audio->arquivo)){
						unlink('arquivos/audios/'.$data->codigo.'/'.$data_audio->arquivo);
					}
					
				}
				
				$conexao = new mysql();
				$conexao->apagar("noticia_audio", " codigo='$data->codigo' ");
				
				$db = new mysql();
				$exec_img = $db->executar("SELECT * FROM noticia_imagem where codigo='$data->codigo' ");
				while($data_img = $exec_img->fetch_object()){

					if($data_img->imagem){
						unlink('arquivos/img_postagens_g/'.$data->codigo.'/'.$data_img->imagem);
						unlink('arquivos/img_postagens_p/'.$data->codigo.'/'.$data_img->imagem);
					}
					 
				}

				$conexao = new mysql();
				$conexao->apagar("noticia_imagem", " codigo='$data->codigo' ");

				$conexao = new mysql();
				$conexao->apagar("noticia", " codigo='$data->codigo' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller);
		
	}


	public function grupos(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Categorias";

		$categorias = new model_postagens();		 
		$dados['categorias'] = $categorias->grupos();		
		

		$this->view('postagens.categorias', $dados);
	}


	public function novo_grupo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Nova Categoria";


		$this->view('postagens.categorias.nova', $dados);
	}


	public function novo_grupo_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia_grupo", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));
	 	
		$this->irpara(DOMINIO.$this->_controller.'/grupos');
		
	}
	
	
	public function alterar_grupo(){
				
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar Grupo";

 		$codigo = $this->get('codigo');

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_grupo WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/grupos');
		}
		
		$this->view('postagens.categorias.alterar', $dados);
		
	}


	public function alterar_grupo_grv(){
				
		$codigo = $this->post('codigo');
		$titulo = $this->post('titulo');		 
		
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("noticia_grupo", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");
	 	
		$this->irpara(DOMINIO.$this->_controller.'/grupos');
		
	}


	public function apagar_grupos(){
		
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia_grupo ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){
				
				$conexao = new mysql();
				$conexao->apagar("noticia_grupo", " id='$data->id' ");
				
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/grupos');
		
	}


	public function destaques(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Destaques";

		$lista = new model_postagens();		 
		$dados['destaques'] = $lista->destaques();
		

		$this->view('postagens.destaques', $dados);
	}


	public function novo_destaque(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Nova Destaque";

		$this->view('postagens.destaques.novo', $dados);
	}


	public function novo_destaque_grv(){
		
		$titulo = $this->post('titulo');

		$this->valida($titulo);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia_destaque", array(
			"codigo"=>"$codigo",
			"titulo"=>"$titulo"
		));
	 	
		$this->irpara(DOMINIO.$this->_controller.'/destaques');		
	}


	public function alterar_destaque(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar Destaque";

 		$codigo = $this->get('codigo');

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_destaque WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/destaques');
		}

		$this->view('postagens.destaques.alterar', $dados);		
	}


	public function alterar_destaque_grv(){
		
		$codigo = $this->post('codigo');

		$titulo = $this->post('titulo');		 
		
		$this->valida($codigo);
		$this->valida($titulo);

		$db = new mysql();
		$db->alterar("noticia_destaque", array(
			"titulo"=>"$titulo"
		), " codigo='$codigo' ");
	 	
		$this->irpara(DOMINIO.$this->_controller.'/destaques');
		
	}


	public function apagar_destaques(){
				
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia_destaque ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){
				
				$conexao = new mysql();
				$conexao->apagar("noticia_destaque", " id='$data->id' ");
					
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/destaques');
		
	}


	public function mascara(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Marca d'água"; 		 

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_marcadagua WHERE id='1' ");
		$data_masc = $exec->fetch_object();

		$lista = new model_mascara();
		$dados['lista'] = $lista->lista($data_masc->codigo);


		$this->view('postagens.mascara', $dados);
	}


	public function mascara_grv(){
		
		$codigo = $this->post('codigo');
		
		$db = new mysql();
		$db->alterar("noticia_marcadagua", array(
			"codigo"=>"$codigo"
		), " id='1' ");
	 	
		$this->irpara(DOMINIO.$this->_controller.'/mascara');
	}


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
		$pasta = "postagens";
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
					
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
					// foto grande
					$largura_g = 1200;
					$altura_g = $img->calcula_altura_jpg($tmp_name, $largura_g);
					// foto minuatura
					$largura_p = 300;
					$altura_p = $img->calcula_altura_jpg($tmp_name, $largura_p);
					//redimenciona
					$img->jpg($diretorio_g.$nome_foto, $largura_g , $altura_g , $diretorio_g.$nome_foto);
					$img->jpg($diretorio_p.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);
					
				} else {
					
					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
				}

				/////////////////////////////////////////////////////////////////////////////////////////////////
				//definições de mascara
				$conexao = new mysql();
			    $coisas = $conexao->Executar("SELECT * FROM noticia_marcadagua where id='1' ");						
				$data = $coisas->fetch_object();
				
				if($data->codigo){
					$mascara = new model_mascara();
					$mascara->aplicar($data->codigo, $diretorio_g.$nome_foto);
				}

				//grava banco
				$db = new mysql();
				$db->inserir("noticia_imagem", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_foto"
				));					
				$ultid = $db->ultimo_id();

				//ordem
				$db = new mysql();
				$exec = $db->executar("SELECT * FROM noticia_imagem_ordem where codigo='$codigo' order by id desc limit 1");
				$data = $exec->fetch_object();
				
				if(isset($data->data)){
					$novaordem = $data->data.",".$ultid;
				} else {
					$novaordem = $ultid;
				}
				
				$db = new mysql();
				$db->inserir("noticia_imagem_ordem", array(
					"codigo"=>"$codigo",
					"data"=>"$novaordem"
				));
			
		}

	}


	public function imagem_manual(){

		$arquivo = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		$codigo = $this->get('codigo');		

		$nome_original = $_FILES['arquivo']['name'];

		//definições de pasta
		$pasta = "postagens";
		$diretorio_g = "arquivos/img_".$pasta."_g/".$codigo."/";
		$diretorio_p = "arquivos/img_".$pasta."_p/".$codigo."/";
		
		if(!is_dir($diretorio_g)) {
			mkdir($diretorio_g);
		}
		if(!is_dir($diretorio_p)) {
			mkdir($diretorio_p);
		}
		
		$img = new model_arquivos_imagens();
 		
		if($tmp_name) {
	 		
			$nome_foto  = $img->trata_nome($nome_original);
			$extensao = $img->extensao($nome_original);
			
			if(copy($tmp_name, $diretorio_g.$nome_foto)){
				
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
					$img->jpg($diretorio_g.$nome_foto, $largura_p , $altura_p , $diretorio_p.$nome_foto);
					
				} else {
					
					//caso nao possa redimencionar copia a imagem original para a pasta de miniaturas
					copy($diretorio_g.$nome_foto, $diretorio_p.$nome_foto);
					
				}
				
				/////////////////////////////////////////////////////////////////////////////////////////////////
				//definições de mascara
				$conexao = new mysql();
			    $coisas = $conexao->Executar("SELECT * FROM noticia_marcadagua where id='1' ");						
				$data = $coisas->fetch_object();
				
				if($data->codigo){
					$mascara = new model_mascara();
					$mascara->aplicar($data->codigo, $diretorio_g.$nome_foto);
				}

				//grava banco
				$db = new mysql();
				$db->inserir("noticia_imagem", array(
					"codigo"=>"$codigo",
					"imagem"=>"$nome_foto"
				));				
				$ultid = $db->ultimo_id();

				//ordem
				$db = new mysql();
				$exec = $db->executar("SELECT * FROM noticia_imagem_ordem where codigo='$codigo' order by id desc limit 1");
				$data = $exec->fetch_object();
				
				if(isset($data->data)){
					$novaordem = $data->data.",".$ultid;
				} else {
					$novaordem = $ultid;
				}
				
				$db = new mysql();
				$db->inserir("noticia_imagem_ordem", array(
					"codigo"=>"$codigo",
					"data"=>"$novaordem"
				));

			} else {
				$this->msg('Erro ao gravar imagem!');				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar/codigo/".$codigo."/aba/imagem");
		}
		
	}


	//apartir daqui autores
	public function autores(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Autores";

		$lista = new model_postagens();		 
		$dados['lista'] = $lista->autores();		 
		

		$this->view('postagens.autores', $dados);
	}


	public function novo_autor(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Nova Autor";


		$this->view('postagens.autores.novo', $dados);
	}


	public function novo_autor_grv(){
		
		$nome = $this->post('nome');
		$descricao = $_POST['descricao'];

		$this->valida($nome);
		
		$codigo = $this->gera_codigo();

		$db = new mysql();
		$db->inserir("noticia_autores", array(
			"codigo"=>"$codigo",
			"nome"=>"$nome",
			"descricao"=>"$descricao"
		));
	 	
		$this->irpara(DOMINIO.$this->_controller.'/alterar_autor/codigo/'.$codigo.'/aba/imagem/');		
	}


	public function alterar_autor(){
		
		$aba = $this->get('aba');
 		if($aba){
 			$dados['aba_selecionada'] = $aba;
 		} else {
 			$dados['aba_selecionada'] = 'dados';
 		}

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
 		$dados['_subtitulo'] = "Alterar Autores";

 		$codigo = $this->get('codigo');

 		$db = new mysql();
		$exec = $db->executar("SELECT * FROM noticia_autores WHERE codigo='$codigo' ");
		$dados['data'] = $exec->fetch_object();

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller.'/autores');
		}

		$this->view('postagens.autores.alterar', $dados);
	}


	public function alterar_autor_grv(){
		
		$codigo = $this->post('codigo');

		$nome = $this->post('nome');		 
		$descricao = $_POST['descricao'];

		$this->valida($codigo);
		$this->valida($nome);

		$db = new mysql();
		$db->alterar("noticia_autores", array(
			"nome"=>"$nome",
			"descricao"=>"$descricao"
		), " codigo='$codigo' ");
	 	
		$this->irpara(DOMINIO.$this->_controller.'/autores');
		
	}


	public function alterar_autor_imagem(){
		
		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];
		
		$arquivo = new model_arquivos_imagens();
 		
		$codigo = $this->get('codigo');
		
		$diretorio = "arquivos/imagens/";
		
		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {
	 		
			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_foto  = $arquivo->trata_nome($nome_original);
			
			if(copy($tmp_name, $diretorio.$nome_foto)){
				
				$db = new mysql();
				$db->alterar("noticia_autores", array(
					"imagem"=>"$nome_foto"
				), " codigo='$codigo' ");

			} else {
				
				$this->msg('Erro ao gravar imagem!');
				
			}

			$this->irpara(DOMINIO.$this->_controller."/alterar_autor/codigo/".$codigo."/aba/imagem");
		}
		
	}


	public function apagar_autor_imagem(){
		
		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT * FROM noticia_autores where codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){
				unlink('arquivos/imagens/'.$data->imagem);
			}
			
			$db = new mysql();
			$db->alterar("noticia_autores", array(
				"imagem"=>""
			), " codigo='$codigo' ");
		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar_autor/codigo/'.$codigo.'/aba/imagem');
	}	


	public function apagar_autores(){
				
		$db = new mysql();
		$exec = $db->Executar("SELECT * FROM noticia_autores ");
		while($data = $exec->fetch_object()){
			
			if($this->post('apagar_'.$data->id) == 1){
				
				if($data->imagem){
					unlink('arquivos/imagens/'.$data->imagem);
				}

				$conexao = new mysql();
				$conexao->apagar("noticia_autores", " id='$data->id' ");
					
			}
		}

		$this->irpara(DOMINIO.$this->_controller.'/autores');
		
	}


//termina classe
}