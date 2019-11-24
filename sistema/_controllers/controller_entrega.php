<?php

class entrega extends controller {
	
	protected $_modulo_nome = "Formas de Entrega";

	public function init(){
		$this->autenticacao();
		$this->nivel_acesso(74);
	}
	
	public function inicial(){
		
		$dados['_base'] = $this->base();
		$dados['_titulo'] = $this->_modulo_nome;
		$dados['_subtitulo'] = "";

		// instancia
		$fretes = new model_fretes();
		
		$dados['lista'] = $fretes->lista();
		
		$this->view('fretes', $dados);
	}
	
	public function detalhes(){
		
		$dados['_base'] = $this->base();

		$id = $this->get('id');

 		// instancia
		$fretes = new model_fretes();
		$valores = new model_valores();

		$dados['data'] = $fretes->carrega($id);
		$data = $dados['data'];

		$dados['acrescimoFixo'] = $valores->trata_valor($data->acrescimo_fixo);
		$dados['gratis_acima_de'] = $valores->trata_valor($data->gratis_acima_de);

		$frete_estado = array();

		$frete_estado[0]['uf'] = 'AC';
		$frete_estado[0]['titulo'] = 'Acre';
		$frete_estado[0]['tipo'] = $data->estado_tipo_AC;
		$frete_estado[0]['valor'] = $valores->trata_valor($data->estado_fixo_AC);
		
		$frete_estado[1]['uf'] = 'AL';
		$frete_estado[1]['titulo'] = 'Alagoas';
		$frete_estado[1]['tipo'] = $data->estado_tipo_AL;
		$frete_estado[1]['valor'] = $valores->trata_valor($data->estado_fixo_AL);

		$frete_estado[2]['uf'] = 'AP';
		$frete_estado[2]['titulo'] = 'Amapá';
		$frete_estado[2]['tipo'] = $data->estado_tipo_AP;
		$frete_estado[2]['valor'] = $valores->trata_valor($data->estado_fixo_AP);

		$frete_estado[3]['uf'] = 'AM';
		$frete_estado[3]['titulo'] = 'Amazonas';
		$frete_estado[3]['tipo'] = $data->estado_tipo_AM;
		$frete_estado[3]['valor'] = $valores->trata_valor($data->estado_fixo_AM);

		$frete_estado[4]['uf'] = 'BA';
		$frete_estado[4]['titulo'] = 'Bahia';
		$frete_estado[4]['tipo'] = $data->estado_tipo_BA;
		$frete_estado[4]['valor'] = $valores->trata_valor($data->estado_fixo_BA);

		$frete_estado[5]['uf'] = 'CE';
		$frete_estado[5]['titulo'] = 'Ceará';
		$frete_estado[5]['tipo'] = $data->estado_tipo_CE;
		$frete_estado[5]['valor'] = $valores->trata_valor($data->estado_fixo_CE);

		$frete_estado[6]['uf'] = 'DF';
		$frete_estado[6]['titulo'] = 'Distrito Federal';
		$frete_estado[6]['tipo'] = $data->estado_tipo_DF;
		$frete_estado[6]['valor'] = $valores->trata_valor($data->estado_fixo_DF);

		$frete_estado[7]['uf'] = 'ES';
		$frete_estado[7]['titulo'] = 'Espírito Santo';
		$frete_estado[7]['tipo'] = $data->estado_tipo_ES;
		$frete_estado[7]['valor'] = $valores->trata_valor($data->estado_fixo_ES);

		$frete_estado[8]['uf'] = 'GO';
		$frete_estado[8]['titulo'] = 'Goiás';
		$frete_estado[8]['tipo'] = $data->estado_tipo_GO;
		$frete_estado[8]['valor'] = $valores->trata_valor($data->estado_fixo_GO);

		$frete_estado[9]['uf'] = 'MA';
		$frete_estado[9]['titulo'] = 'Maranhão';
		$frete_estado[9]['tipo'] = $data->estado_tipo_MA;
		$frete_estado[9]['valor'] = $valores->trata_valor($data->estado_fixo_MA);

		$frete_estado[10]['uf'] = 'MT';
		$frete_estado[10]['titulo'] = 'Mato Grosso';
		$frete_estado[10]['tipo'] = $data->estado_tipo_MT;
		$frete_estado[10]['valor'] = $valores->trata_valor($data->estado_fixo_MT);

		$frete_estado[11]['uf'] = 'MS';
		$frete_estado[11]['titulo'] = 'Mato Grosso do Sul';
		$frete_estado[11]['tipo'] = $data->estado_tipo_MS;
		$frete_estado[11]['valor'] = $valores->trata_valor($data->estado_fixo_MS);

		$frete_estado[12]['uf'] = 'MG';
		$frete_estado[12]['titulo'] = 'Minas Gerais';
		$frete_estado[12]['tipo'] = $data->estado_tipo_MG;
		$frete_estado[12]['valor'] = $valores->trata_valor($data->estado_fixo_MG);

		$frete_estado[13]['uf'] = 'PA';
		$frete_estado[13]['titulo'] = 'Pará';
		$frete_estado[13]['tipo'] = $data->estado_tipo_PA;
		$frete_estado[13]['valor'] = $valores->trata_valor($data->estado_fixo_PA);

		$frete_estado[14]['uf'] = 'PB';
		$frete_estado[14]['titulo'] = 'Paraíba';
		$frete_estado[14]['tipo'] = $data->estado_tipo_PB;
		$frete_estado[14]['valor'] = $valores->trata_valor($data->estado_fixo_PB);

		$frete_estado[15]['uf'] = 'PR';
		$frete_estado[15]['titulo'] = 'Paraná';
		$frete_estado[15]['tipo'] = $data->estado_tipo_PR;
		$frete_estado[15]['valor'] = $valores->trata_valor($data->estado_fixo_PR);

		$frete_estado[16]['uf'] = 'PE';
		$frete_estado[16]['titulo'] = 'Pernambuco';
		$frete_estado[16]['tipo'] = $data->estado_tipo_PE;
		$frete_estado[16]['valor'] = $valores->trata_valor($data->estado_fixo_PE);

		$frete_estado[17]['uf'] = 'PI';
		$frete_estado[17]['titulo'] = 'Piauí';
		$frete_estado[17]['tipo'] = $data->estado_tipo_PI;
		$frete_estado[17]['valor'] = $valores->trata_valor($data->estado_fixo_PI);

		$frete_estado[18]['uf'] = 'RJ';
		$frete_estado[18]['titulo'] = 'Rio de Janeiro';
		$frete_estado[18]['tipo'] = $data->estado_tipo_RJ;
		$frete_estado[18]['valor'] = $valores->trata_valor($data->estado_fixo_RJ);

		$frete_estado[19]['uf'] = 'RN';
		$frete_estado[19]['titulo'] = 'Rio Grande do Norte';
		$frete_estado[19]['tipo'] = $data->estado_tipo_RN;
		$frete_estado[19]['valor'] = $valores->trata_valor($data->estado_fixo_RN);

		$frete_estado[20]['uf'] = 'RS';
		$frete_estado[20]['titulo'] = 'Rio Grande do Sul';
		$frete_estado[20]['tipo'] = $data->estado_tipo_RS;
		$frete_estado[20]['valor'] = $valores->trata_valor($data->estado_fixo_RS);

		$frete_estado[21]['uf'] = 'RO';
		$frete_estado[21]['titulo'] = 'Rondônia';
		$frete_estado[21]['tipo'] = $data->estado_tipo_RO;
		$frete_estado[21]['valor'] = $valores->trata_valor($data->estado_fixo_RO);

		$frete_estado[22]['uf'] = 'RR';
		$frete_estado[22]['titulo'] = 'Roraima';
		$frete_estado[22]['tipo'] = $data->estado_tipo_RR;
		$frete_estado[22]['valor'] = $valores->trata_valor($data->estado_fixo_RR);

		$frete_estado[23]['uf'] = 'SC';
		$frete_estado[23]['titulo'] = 'Santa Catarina';
		$frete_estado[23]['tipo'] = $data->estado_tipo_SC;
		$frete_estado[23]['valor'] = $valores->trata_valor($data->estado_fixo_SC);

		$frete_estado[24]['uf'] = 'SP';
		$frete_estado[24]['titulo'] = 'São Paulo';
		$frete_estado[24]['tipo'] = $data->estado_tipo_SP;
		$frete_estado[24]['valor'] = $valores->trata_valor($data->estado_fixo_SP);

		$frete_estado[25]['uf'] = 'SE';
		$frete_estado[25]['titulo'] = 'Sergipe';
		$frete_estado[25]['tipo'] = $data->estado_tipo_SE;
		$frete_estado[25]['valor'] = $valores->trata_valor($data->estado_fixo_SE);
		
		$frete_estado[26]['uf'] = 'TO';
		$frete_estado[26]['titulo'] = 'Tocantins';
		$frete_estado[26]['tipo'] = $data->estado_tipo_TO;
		$frete_estado[26]['valor'] = $valores->trata_valor($data->estado_fixo_TO);
		
		$dados['frete_estado'] = $frete_estado;
		
		$this->view('fretes.detalhes', $dados);
	}
	
	public function alterar_grv(){
		
		$id = $this->post('id');
		$titulo_exibicao =  $this->post('titulo_exibicao');

		$this->valida($id);
		$this->valida($titulo_exibicao);

		// instancia
		$fretes = new model_fretes();
		$valores = new model_valores();
		
		$cep = $this->post('cep');
		$proximidade_cidade = $this->post('proximidade_cidade');

		$acrescimo_fixo = $this->post('acrescimo_fixo');
		$acrescimo_fixo = $valores->trata_valor_banco($acrescimo_fixo);
		
		$acrescimo_porc = $this->post('acrescimo_porc');
		
		$ativo = $this->post('ativo');
		$gratis_acima_de = $this->post('gratis_acima_de');
		$gratis_acima_de = $valores->trata_valor_banco($gratis_acima_de);

		$estado_tipo_AC = $this->post('estado_tipo_AC');
		$estado_fixo_AC = $valores->trata_valor_banco($this->post('estado_fixo_AC'));

		$estado_tipo_AL = $this->post('estado_tipo_AL');
		$estado_fixo_AL = $valores->trata_valor_banco($this->post('estado_fixo_AL'));

		$estado_tipo_AP = $this->post('estado_tipo_AP');
		$estado_fixo_AP = $valores->trata_valor_banco($this->post('estado_fixo_AP'));

		$estado_tipo_AM = $this->post('estado_tipo_AM');
		$estado_fixo_AM = $valores->trata_valor_banco($this->post('estado_fixo_AM'));

		$estado_tipo_BA = $this->post('estado_tipo_BA');
		$estado_fixo_BA = $valores->trata_valor_banco($this->post('estado_fixo_BA'));

		$estado_tipo_CE = $this->post('estado_tipo_CE');
		$estado_fixo_CE = $valores->trata_valor_banco($this->post('estado_fixo_CE'));

		$estado_tipo_DF = $this->post('estado_tipo_DF');
		$estado_fixo_DF = $valores->trata_valor_banco($this->post('estado_fixo_DF'));

		$estado_tipo_ES = $this->post('estado_tipo_ES');
		$estado_fixo_ES = $valores->trata_valor_banco($this->post('estado_fixo_ES'));

		$estado_tipo_GO = $this->post('estado_tipo_GO');
		$estado_fixo_GO = $valores->trata_valor_banco($this->post('estado_fixo_GO'));

		$estado_tipo_MA = $this->post('estado_tipo_MA');
		$estado_fixo_MA = $valores->trata_valor_banco($this->post('estado_fixo_MA'));

		$estado_tipo_MT = $this->post('estado_tipo_MT');
		$estado_fixo_MT = $valores->trata_valor_banco($this->post('estado_fixo_MT'));

		$estado_tipo_MS = $this->post('estado_tipo_MS');
		$estado_fixo_MS = $valores->trata_valor_banco($this->post('estado_fixo_MS'));

		$estado_tipo_MG = $this->post('estado_tipo_MG');
		$estado_fixo_MG = $valores->trata_valor_banco($this->post('estado_fixo_MG'));

		$estado_tipo_PA = $this->post('estado_tipo_PA');
		$estado_fixo_PA = $valores->trata_valor_banco($this->post('estado_fixo_PA'));

		$estado_tipo_PB = $this->post('estado_tipo_PB');
		$estado_fixo_PB = $valores->trata_valor_banco($this->post('estado_fixo_PB'));

		$estado_tipo_PR = $this->post('estado_tipo_PR');
		$estado_fixo_PR = $valores->trata_valor_banco($this->post('estado_fixo_PR'));

		$estado_tipo_PE = $this->post('estado_tipo_PE');
		$estado_fixo_PE = $valores->trata_valor_banco($this->post('estado_fixo_PE'));

		$estado_tipo_PI = $this->post('estado_tipo_PI');
		$estado_fixo_PI = $valores->trata_valor_banco($this->post('estado_fixo_PI'));

		$estado_tipo_RJ = $this->post('estado_tipo_RJ');
		$estado_fixo_RJ = $valores->trata_valor_banco($this->post('estado_fixo_RJ'));

		$estado_tipo_RN = $this->post('estado_tipo_RN');
		$estado_fixo_RN = $valores->trata_valor_banco($this->post('estado_fixo_RN'));

		$estado_tipo_RS = $this->post('estado_tipo_RS');
		$estado_fixo_RS = $valores->trata_valor_banco($this->post('estado_fixo_RS'));

		$estado_tipo_RO = $this->post('estado_tipo_RO');
		$estado_fixo_RO = $valores->trata_valor_banco($this->post('estado_fixo_RO'));

		$estado_tipo_RR = $this->post('estado_tipo_RR');
		$estado_fixo_RR = $valores->trata_valor_banco($this->post('estado_fixo_RR'));

		$estado_tipo_SC = $this->post('estado_tipo_SC');
		$estado_fixo_SC = $valores->trata_valor_banco($this->post('estado_fixo_SC'));

		$estado_tipo_SP = $this->post('estado_tipo_SP');
		$estado_fixo_SP = $valores->trata_valor_banco($this->post('estado_fixo_SP'));

		$estado_tipo_SE = $this->post('estado_tipo_SE');
		$estado_fixo_SE = $valores->trata_valor_banco($this->post('estado_fixo_SE'));

		$estado_tipo_TO = $this->post('estado_tipo_TO');
		$estado_fixo_TO = $valores->trata_valor_banco($this->post('estado_fixo_TO'));	
		
		
		// executa
		$db = new mysql();
		$db->alterar('frete', array(
			'titulo_exibicao'	=>$titulo_exibicao,
			'cep' 				=>$cep,
			'acrescimo_fixo'	=>$acrescimo_fixo,
			'acrescimo_porc'	=>$acrescimo_porc,
			'ativo'				=>$ativo,
			'gratis_acima_de'	=>$gratis_acima_de,
			'estado_tipo_AC'	=>$estado_tipo_AC,
			'estado_fixo_AC'	=>$estado_fixo_AC,
			'estado_tipo_AL'	=>$estado_tipo_AL,
			'estado_fixo_AL'	=>$estado_fixo_AL,
			'estado_tipo_AP'	=>$estado_tipo_AP,
			'estado_fixo_AP'	=>$estado_fixo_AP,
			'estado_tipo_AM'	=>$estado_tipo_AM,
			'estado_fixo_AM'	=>$estado_fixo_AM,
			'estado_tipo_BA'	=>$estado_tipo_BA,
			'estado_fixo_BA'	=>$estado_fixo_BA,
			'estado_tipo_CE'	=>$estado_tipo_CE,
			'estado_fixo_CE'	=>$estado_fixo_CE,
			'estado_tipo_DF'	=>$estado_tipo_DF,
			'estado_fixo_DF'	=>$estado_fixo_DF,
			'estado_tipo_ES'	=>$estado_tipo_ES,
			'estado_fixo_ES'	=>$estado_fixo_ES,
			'estado_tipo_GO'	=>$estado_tipo_GO,
			'estado_fixo_GO'	=>$estado_fixo_GO,
			'estado_tipo_MA'	=>$estado_tipo_MA,
			'estado_fixo_MA'	=>$estado_fixo_MA,
			'estado_tipo_MT'	=>$estado_tipo_MT,
			'estado_fixo_MT'	=>$estado_fixo_MT,
			'estado_tipo_MS'	=>$estado_tipo_MS,
			'estado_fixo_MS'	=>$estado_fixo_MS,
			'estado_tipo_MG'	=>$estado_tipo_MG,
			'estado_fixo_MG'	=>$estado_fixo_MG,
			'estado_tipo_PA'	=>$estado_tipo_PA,
			'estado_fixo_PA'	=>$estado_fixo_PA,
			'estado_tipo_PB'	=>$estado_tipo_PB,
			'estado_fixo_PB'	=>$estado_fixo_PB,
			'estado_tipo_PR'	=>$estado_tipo_PR,
			'estado_fixo_PR'	=>$estado_fixo_PR,
			'estado_tipo_PE'	=>$estado_tipo_PE,
			'estado_fixo_PE'	=>$estado_fixo_PE,
			'estado_tipo_PI'	=>$estado_tipo_PI,
			'estado_fixo_PI'	=>$estado_fixo_PI,
			'estado_tipo_RJ'	=>$estado_tipo_RJ,
			'estado_fixo_RJ'	=>$estado_fixo_RJ,
			'estado_tipo_RN'	=>$estado_tipo_RN,
			'estado_fixo_RN'	=>$estado_fixo_RN,
			'estado_tipo_RS'	=>$estado_tipo_RS,
			'estado_fixo_RS'	=>$estado_fixo_RS,
			'estado_tipo_RO'	=>$estado_tipo_RO,
			'estado_fixo_RO'	=>$estado_fixo_RO,
			'estado_tipo_RR'	=>$estado_tipo_RR,
			'estado_fixo_RR'	=>$estado_fixo_RR,
			'estado_tipo_SC'	=>$estado_tipo_SC,
			'estado_fixo_SC'	=>$estado_fixo_SC,
			'estado_tipo_SP'	=>$estado_tipo_SP,
			'estado_fixo_SP'	=>$estado_fixo_SP,
			'estado_tipo_SE'	=>$estado_tipo_SE,
			'estado_fixo_SE'	=>$estado_fixo_SE,
			'estado_tipo_TO'	=>$estado_tipo_TO,
			'estado_fixo_TO'	=>$estado_fixo_TO,
			'proximidade_cidade'=>$proximidade_cidade
		), " id='$id' "); 
		
		$this->irpara(DOMINIO.$this->_controller);		
	}

}