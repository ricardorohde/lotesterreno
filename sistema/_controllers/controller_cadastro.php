<?php

class cadastro extends controller {
	
	protected $_modulo_nome = "Clientes";
	
	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(76);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";
		
		$db = new model_cadastros();
		$dados['lista'] = $db->lista();
		
		$dados['aniversariantes'] = false;

		$this->view('cadastro', $dados);
	}

	public function detalhes(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Detalhes";

		$codigo = $this->get('codigo');

 		//instancia cadastros
		$cadastro = new model_cadastros();

 		//dados
		$dados['data'] = $cadastro->seleciona($codigo);

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller);
		}

		//comentarios
		$dados['comentarios'] = $cadastro->comentarios($codigo);

		$dados['avalistas'] = $cadastro->lista();

		$this->view('cadastro.detalhes', $dados);
	}
	
	public function novo(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		
		$this->view('cadastro.novo', $dados);
	}

	public function novo_grv(){
		
		$tipo = $this->post('tipo');
		$nome = $this->post('nome');

		$this->valida($tipo);
		$this->valida($nome);

		$codigo = $this->gera_codigo();
		
		if($tipo == "J"){

			$db = new mysql();
			$db->inserir("cadastro", array(
				"codigo"=>"$codigo",
				"tipo"=>"$tipo",
				"juridica_razao"=>"$nome"
			));
			
		} else {
			
			$db = new mysql();
			$db->inserir("cadastro", array(
				"codigo"=>"$codigo",
				"tipo"=>"$tipo",
				"fisica_nome"=>"$nome"
			));

		}

		$this->irpara(DOMINIO.$this->_controller.'/alterar/codigo/'.$codigo);
	}

	public function alterar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Alterar";

		$codigo = $this->get('codigo');

 		//instancia cadastros
		$cadastro = new model_cadastros();

 		//dados
		$dados['data'] = $cadastro->seleciona($codigo);

		if(!isset($dados['data']) ) {
			$this->irpara(DOMINIO.$this->_controller);
		}

		$estado = new model_estados_cidades();
		$dados['estados'] = $estado->lista();

		$this->view('cadastro.alterar', $dados);
	}

	public function alterar_grv(){

		$codigo = $this->post('codigo');

		$tipo = $this->post('tipo');

		$fisica_nome = $this->post('fisica_nome');
		$juridica_nome = $this->post('juridica_nome');

		$juridica_razao = $this->post('juridica_razao');
		$juridica_cnpj = $this->post('juridica_cnpj');
		$juridica_ie = $this->post('juridica_ie'); 
		$juridica_responsavel = $this->post('juridica_responsavel');

		$fisica_cpf = $this->post('fisica_cpf'); 

		$telefone = $this->post('telefone');
		$email = $this->post('email');

		$fisica_nascimento = $this->post('fisica_nascimento');
		$fisica_sexo = $this->post('fisica_sexo');

		$endereco = $this->post('endereco');
		$numero = $this->post('numero');
		$complemento = $this->post('complemento');
		$bairro = $this->post('bairro');
		$cep = $this->post('cep');
		$estado = $this->post('estado');
		$cidade = $this->post('cidade');

		$valida = new model_valida();

		require_once("_api/cpf_cnpj/cpf_cnpj.php"); 

		if($tipo == 'J'){
			//validacoes
			if($juridica_cnpj){
				$cpf_cnpj = new valida_cpf_cnpj("$juridica_cnpj");
				if(!$cpf_cnpj->valida()){
					$this->msg("CNPJ inválido!");
					$this->volta(1);
				}
			}
			if($fisica_cpf){
				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if(!$cpf_cnpj->valida()){
					$this->msg("CPF inválido!");
					$this->volta(1);				
				}
			}
		} else {
			//validacoes
			if($fisica_cpf){
				$cpf_cnpj = new valida_cpf_cnpj("$fisica_cpf");
				if(!$cpf_cnpj->valida()){
					$this->msg("CPF inválido!");
					$this->volta(1);				
				}
			} 
		}

		//validacoes
		$this->valida($tipo);

		if($email){

			if(!$valida->email($email)){
				$this->msg('E-mail inválido');
				$this->volta(1);
			}

			$conexao = new mysql();
			$coisas = $conexao->Executar("SELECT * FROM cadastro WHERE email='$email' AND codigo!='$codigo' ");
			$linhas = $coisas->num_rows;

			if($linhas != 0){
				$this->msg('Este e-mail já está cadastrado');
				$this->volta(1);
			}

		} else {

			$this->msg('E-mail inválido');
			$this->volta(1);

		}

		if($fisica_nascimento){

			// transforma data em inteiro
			$arraydata = explode("/", $fisica_nascimento);				
			$hora_montada = $arraydata[2]."-".$arraydata[1]."-".$arraydata[0]." 00:00:01";
			$fisica_nascimento = strtotime($hora_montada);

		}


		$time = time();

		$db = new mysql();
		$db->alterar("cadastro", array(
			"tipo"=>"$tipo",
			"fisica_nome"=>"$fisica_nome",
			"fisica_sexo"=>"$fisica_sexo",
			"fisica_nascimento"=>"$fisica_nascimento",
			"fisica_cpf"=>"$fisica_cpf",
			"juridica_nome"=>"$juridica_nome",
			"juridica_razao"=>"$juridica_razao",
			"juridica_responsavel"=>"$juridica_responsavel",
			"juridica_cnpj"=>"$juridica_cnpj",
			"juridica_ie"=>"$juridica_ie",
			"cep"=>"$cep",
			"endereco"=>"$endereco",
			"numero"=>"$numero",
			"complemento"=>"$complemento",
			"bairro"=>"$bairro",
			"estado"=>"$estado",
			"cidade"=>"$cidade",
			"telefone"=>"$telefone",
			"email"=>"$email"
		), " codigo='$codigo' ");


		$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);
	}

	public function avalista_grv(){

		$codigo = $this->post('codigo');
		$avalista = $this->post('avalista');

		if($codigo AND $avalista){

			$db = new mysql();
			$db->alterar("cadastro", array(			
				"avalista"=>"$avalista"
			), " codigo='$codigo' ");

			$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);

		} else {
			$this->msg('Preencha todos os campos!');
			$this->volta(1);
		}

	}

	public function apagar_varios(){ 

		$db = new mysql();
		$exec = $db->executar("SELECT id, codigo, imagem FROM cadastro ");
		while($data = $exec->fetch_object()){

			if($this->post('apagar_'.$data->id) == 1){

				if($data->imagem){

					unlink('arquivos/img_clientes/'.$data->imagem);

				}

				$remove = new mysql();
				$remove->apagar("cadastro_comentarios", " cadastro='$data->codigo' ");

				$remove = new mysql();
				$remove->apagar("cadastro", " id='$data->id' ");

			}
		}

		$this->irpara(DOMINIO.$this->_controller);
	}


	public function comentario_grv(){

		$codigo = $this->post('codigo');
		$comentario = nl2br($this->post('comentario'));
		$time = time();

		$db = new mysql();
		$db->inserir("cadastro_comentarios", array(
			"usuario"=>"$this->_cod_usuario",
			"cadastro"=>"$codigo",
			"data"=>"$time",
			"comentario"=>"$comentario"
		));

		$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);
	}

	public function comentario_apagar(){

		$codigo = $this->get('cadastro');
		$id = $this->get('id');

		if($id AND $codigo){

			$remove = new mysql();
			$remove->apagar("cadastro_comentarios", " id='$id' ");

		}

		$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);
	}


	public function alterar_imagem(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;

		$dados['codigo'] = $this->get('codigo');


		$this->view('cadastro.alterar.imagem', $dados);
	}

	public function alterar_imagem_grv(){

		$arquivo_original = $_FILES['arquivo'];
		$tmp_name = $_FILES['arquivo']['tmp_name'];

		//carrega model de gestao de imagens
		$arquivo = new model_arquivos_imagens();

		$codigo = $this->post('codigo');

		$diretorio = "arquivos/img_clientes/";

		if(!$arquivo->filtro($arquivo_original)){ $this->msg('Arquivo com formato inválido ou inexistente!'); $this->volta(1); } else {

			//pega a exteção
			$nome_original = $arquivo_original['name'];
			$extensao = $arquivo->extensao($nome_original);
			$nome_arquivo  = $arquivo->trata_nome($nome_original);

			if(copy($tmp_name, $diretorio.$nome_arquivo)){

				if( ($extensao == "jpg") OR ($extensao == "jpeg") OR ($extensao == "JPG") OR ($extensao == "JPEG") ){

					//calcula a 
					$largura_g = 1200;
					$altura_g = $arquivo->calcula_altura_jpg($diretorio.$nome_arquivo, $largura_g);

					//redimenciona
					$arquivo->jpg($diretorio.$nome_arquivo, $largura_g , $altura_g , $diretorio.$nome_arquivo);
				}

				// remove imagem anterior

				$db = new mysql();
				$exec = $db->executar("SELECT imagem FROM cadastro where codigo='$codigo' ");
				$data = $exec->fetch_object();

				if($data->imagem){
					unlink('arquivos/img_clientes/'.$data->imagem); 
				}

				//grava banco

				$db = new mysql();
				$db->alterar("cadastro", array(			
					"imagem"=>"$nome_arquivo"
				), " codigo='$codigo' ");


				$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);

			} else {

				$this->msg('Erro ao gravar imagem!');
				$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);

			}

		}		

	}

	public function apagar_imagem(){

		$codigo = $this->get('codigo');

		if($codigo){

			$db = new mysql();
			$exec = $db->executar("SELECT imagem FROM cadastro where codigo='$codigo' ");
			$data = $exec->fetch_object();

			if($data->imagem){

				unlink('arquivos/img_clientes/'.$data->imagem);

				$db = new mysql();
				$db->alterar("cadastro", array(			
					"imagem"=>""
				), " codigo='$codigo' ");
			}

		} else {
			$this->msg("erro");
		}

		$this->irpara(DOMINIO.$this->_controller.'/detalhes/codigo/'.$codigo);		
	}

	public function exportar(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar";

		$dados['mostrar_lista'] = false;
		$dados['aniversariantes'] = false;

		// intancia
		$cadastro = new model_cadastros();

		$formato = $this->post('formato');
		$dados['formato'] = $formato;

		if($formato){

			$dados['mostrar_lista'] = true;

			if($formato == 1){
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';
			foreach ($cadastro->lista() as $key => $value) {				 
				$lista_exportada .= $value['email'].$separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.exportar', $dados);
	}

	public function exportar_aniversariantes(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Exportar Aniversariantes";

		$dados['mostrar_lista'] = false;
		$dados['aniversariantes'] = true;

		// intancia
		$cadastro = new model_cadastros();

		$formato = $this->post('formato');
		$dados['formato'] = $formato;

		if($formato){

			$dados['mostrar_lista'] = true;

			if($formato == 1){
				$separador = ';';
			} else {
				$separador = ',';
			}

			$lista_exportada = '';
			foreach ($cadastro->aniversariantes() as $key => $value) {				 
				$lista_exportada .= $value['email'].$separador;
			}

			$dados['lista_exportada'] = $lista_exportada;
		}

		$this->view('cadastro.exportar', $dados);
	}


	public function aniversariantes(){

		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "Aniversariantes";

		$db = new model_cadastros();
		$dados['lista'] = $db->aniversariantes();

		$dados['aniversariantes'] = true;

		$this->view('cadastro', $dados);
	}

}