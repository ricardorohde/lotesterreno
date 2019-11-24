<?php
class cadastro extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		$this->irpara(DOMINIO);
	}	 
	
	public function gravar_email(){
		
		$dados = array();
		$dados['_base'] = $this->_base();
		
		$nome = $this->post('nome');
		$email = $this->post('email');
		
		if($nome AND $email){

			$valida = new model_valida();
			if($valida->email($email)){

				$db = new mysql();
				$exec = $db->executar("select * from cadastro_email WHERE email='$email' ");
				if($exec->num_rows == 0){

					$codigo = $this->gera_codigo();

					$db = new mysql();
					$db->inserir("cadastro_email", array(
						"codigo"=>$codigo,
						"nome"=>$nome,
						"email"=>$email
					));

				}
				
				echo "Obrigado, seu cadastro foi enviado com sucesso!";
				exit;
				
			} else {
				echo "E-mail inválido!";
				exit;
			}
			
		} else {
			echo "Preencha corretamente seu e-mail!";
			exit;
		}
		
	}

}