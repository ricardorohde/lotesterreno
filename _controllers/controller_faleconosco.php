<?php
class faleconosco extends controller {
	
	public function init(){
	}
	
	public function inicial(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		//carrega view e envia dados para a tela
		$this->view('faleconosco', $dados);
	}

	public function ligamos(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		//carrega view e envia dados para a tela
		$this->view('faleconosco.ligamos', $dados);
	}

	public function cadastre(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		//carrega view e envia dados para a tela
		$this->view('faleconosco.cadastre', $dados);
	}

	public function encomende(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		//carrega view e envia dados para a tela
		$this->view('faleconosco.encomende', $dados);
	}

	public function financiamento(){

		$dados = array();
		$dados['_base'] = $this->_base();
		$dados['objeto'] = DOMINIO.$this->_controller.'/';
		$dados['controller'] = $this->_controller;
		
		//carrega view e envia dados para a tela
		$this->view('faleconosco.financiamento', $dados);
	}

	public function desejo(){

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

		//carrega view e envia dados para a tela
		$this->view('faleconosco.desejo', $dados);
	}

	// captchas

	public function captcha(){
		
		$codigoCaptcha = substr(md5( time()) ,0,5);
		
		$_SESSION['captcha'] = $codigoCaptcha;
		
		$imagemCaptcha = imagecreatefrompng("_views/img/fundocaptch.png");

		$fonteCaptcha = imageloadfont("_views/img/anonymous.gdf");
		
		$corCaptcha = imagecolorallocate($imagemCaptcha,255,0,0);
		
		imagestring($imagemCaptcha,$fonteCaptcha,15,5,$codigoCaptcha,$corCaptcha);
		
		header("Content-type: image/png");
		
		imagepng($imagemCaptcha);
		
		imagedestroy($imagemCaptcha);
		exit;
	}

	private function captcha_alt(){

		require_once("_api/simple-php-captcha-master/simple-php-captcha.php");

		$retorno = simple_php_captcha(); 		
		$_SESSION['captcha'] = $retorno['code'];

		return $retorno['image_src'];
	}

	// envios

	public function ligamos_enviar(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		
		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$interesse = $this->post('interesse');
		$horario = $this->post('horario');

		if($nome AND $email AND $fone){
			
			/* mensagem */
			$msg =  "<p style='font-family:Arial,sans-serif;'><strong>Pedido de Ligue-me enviado pelo Website</strong></p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>E-mail:</strong> ".$email."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Interesse:</strong> ".$interesse."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Horario:</strong> ".$horario."</p>";
			
			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio = array();
			$n = 0;
			while($data = $exec->fetch_object()){
				$lista_envio[$n] = $data->email;
				$n++;
			}
			
			$envio = new model_envio();
			//$retorno_envio = $envio->enviar($assunto, $msg, $emails_destino, $email_resposta);
			
			$retorno = $envio->enviar("Pedido de Ligue-me enviado pelo Website", $msg, $lista_envio, $email);
			$this->msg($retorno);
			$this->volta(1);
			exit;
			
		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function contato_enviar(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		
		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		
		if($nome AND $email){
			
			/* mensagem */
			$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Contato enviado pelo Website</strong></p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";
			
			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio = array();
			$n = 0;
			while($data = $exec->fetch_object()){
				$lista_envio[$n] = $data->email;
				$n++;
			}
			
			$envio = new model_envio();
			//$retorno_envio = $envio->enviar($assunto, $msg, $emails_destino, $email_resposta);
			
			$retorno = $envio->enviar("Nova mensagem enviada pelo website", $msg, $lista_envio, $email);
			$this->msg($retorno);
			$this->volta(1);
			exit;
			
		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}

	public function desejo_enviar(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		
		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$mensagem = $this->post('msg');
		$imovel = $this->post('imovel');

		if($nome AND $email AND $imovel){
			
			/* mensagem */
			$msg =  "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Desejo receber mais informações enviado pelo Website</strong></p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>E-mail:</strong> ".$email."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Imóvel:</strong> ".$imovel."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif; font-size:12px;'><strong>Mensagem:</strong> ".$mensagem."</p>";
			
			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio = array();
			$n = 0;
			while($data = $exec->fetch_object()){
				$lista_envio[$n] = $data->email;
				$n++;
			}
			
			$envio = new model_envio();
			//$retorno_envio = $envio->enviar($assunto, $msg, $emails_destino, $email_resposta);
			
			$retorno = $envio->enviar("Novo pedido de informações enviado pelo website", $msg, $lista_envio, $email);
			$this->msg($retorno);
			$this->volta(1);
			exit;
			
		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}

	}
	
	public function cadastre_enviar(){
		
		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$celular = $this->post('celular');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		$descricao = $this->post('descricao');
		
		if($nome AND $email){
			
			/* mensagem */
			$msg =  "<p style='font-family:Arial,sans-serif;'><strong>Solicitação de Cadastro de Imóvel</strong></p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>E-mail:</strong> ".$email."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Celular:</strong> ".$celular."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Cidade:</strong> ".$cidade."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Bairro:</strong> ".$bairro."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Descrição:</strong> ".$descricao."</p>";
			
			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio = array();
			$n = 0;
			while($data = $exec->fetch_object()){
				$lista_envio[$n] = $data->email;
				$n++;
			}
			
			$envio = new model_envio();
			//$retorno_envio = $envio->enviar($assunto, $msg, $emails_destino, $email_resposta);
			
			$retorno = $envio->enviar("Nova solicitação de cadastro enviada pelo website", $msg, $lista_envio, $email);
			$this->msg($retorno);
			$this->volta(1);
			exit;
			
		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}		
	}

	public function encomende_enviar(){
		
		$dados = array();
		$dados['_base'] = $this->_base();

		$nome = $this->post('nome');
		$email = $this->post('email');
		$fone = $this->post('fone');
		$celular = $this->post('celular');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		$descricao = $this->post('descricao');
		
		if($nome AND $email){
			
			/* mensagem */
			$msg =  "<p style='font-family:Arial,sans-serif;'><strong>Solicitação de Encomenda de Imóvel</strong></p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Nome:</strong> ".$nome."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>E-mail:</strong> ".$email."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Telefone:</strong> ".$fone."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Celular:</strong> ".$celular."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Cidade:</strong> ".$cidade."</p>";
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Bairro:</strong> ".$bairro."</p>"; 
			$msg .= "<p style='font-family:Arial,sans-serif;'><strong>Descrição:</strong> ".$descricao."</p>"; 

			$db = new mysql();
			$exec = $db->executar("select * from contato ");
			$lista_envio = array();
			$n = 0;
			while($data = $exec->fetch_object()){
				$lista_envio[$n] = $data->email;
				$n++;
			}
			
			$envio = new model_envio();
			//$retorno_envio = $envio->enviar($assunto, $msg, $emails_destino, $email_resposta);
			
			$retorno = $envio->enviar("Nova solicitação de Encomenda enviada pelo website", $msg, $lista_envio, $email);
			$this->msg($retorno);
			$this->volta(1);
			exit;
			
		} else {
			$this->msg("Preencha todos os campos para continuar");
			$this->volta(1);
			exit;
		}		
	}
}