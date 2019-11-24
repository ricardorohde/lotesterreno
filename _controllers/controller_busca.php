<?php
class busca extends controller {
	
	public function init(){
	}
	
	public function inicial(){
		
		$referencia = $this->post('referencia');
		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo');
		$cidade = $this->post('cidade');
		$bairro = $this->post('bairro');
		
		if($referencia){
			$cidade = "cidade";
			$bairro = "bairro";
			$tipo = "tipo";
			$categoria = "categoria";
		} else {
			$referencia = 'referencia';
			if(!$categoria){
				$categoria = "categoria";
			}
			if(!$tipo){
				$tipo = "tipo";
			}
			if(!$cidade){
				$cidade = "cidade";
			}
			if(!$bairro){
				$bairro = "bairro";
			}
		}
		
		$endereco = DOMINIO."imoveis/lista/referencia/$referencia/categoria/$categoria/tipo/$tipo/cidade/$cidade/bairro/$bairro#busca";

		$this->irpara("$endereco");
	}

	public function filtrar(){

		$valores = new model_valores();

		$referencia = "referencia";
		$categoria = $this->post('categoria');
		$tipo = $this->post('tipo');
		$cidade = $this->post('cidade');

		$bairro = $this->post('bairro');
		$dormitorios = $this->post('dormitorios');
		$suites = $this->post('suites');
		$ordem = $this->post('ordem');

		if($categoria == 'alugar'){
			$valor_min = $this->post('alugar_valor_min');
			$valor_max = $this->post('alugar_valor_max');
		} else {
			$valor_min = $this->post('comprar_valor_min');
			$valor_max = $this->post('comprar_valor_max');
		}
		
		if($valor_min == 'MÍNIMO'){
			$valor_min = 'minimo';
		} else {
			$valor_min = $valores->trata_valor_banco( str_replace(array(" ", "R$"), "", $valor_min) );
		}

		if($valor_max == 'MÁXIMO'){
			$valor_max = 'maximo';
		} else {
			$valor_max = $valores->trata_valor_banco( str_replace(array(" ", "R$"), "", $valor_max) );
		}

		$endereco = DOMINIO."imoveis/lista/referencia/$referencia/categoria/$categoria/tipo/$tipo/cidade/$cidade/bairro/$bairro/dormitorios/$dormitorios/suites/$suites/valor_maximo/$valor_max/valor_minimo/$valor_min/ordem/$ordem#busca";

		$this->irpara($endereco);
	}
}