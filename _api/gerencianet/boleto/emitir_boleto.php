<?php

require_once('../../_config.php');
require __DIR__ . '/../api/vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$client_id = $_GET['gerencianet_clientId'];
$clientSecret = $_GET['gerencianet_clientSecret'];

$options = [
    'client_id' => $client_id,
    'client_secret' => $clientSecret,
    'sandbox' => false // altere conforme o ambiente (true = desenvolvimento e false = produção)
];

if (isset($_POST)) {
    
    $item_1 = [
        'name' => $_POST["descricao"],
        'amount' => (int) $_POST["quantidade"],
        'value' => (int) $_POST["valor"]
    ];
    
    $items = [
        $item_1
    ];
    
    $body = ['items' => $items];
    
    try {
        $api = new Gerencianet($options);
        $charge = $api->createCharge([], $body);
        if ($charge["code"] == 200) {

            $params = ['id' => $charge["data"]["charge_id"]];

            //tipo pessoa fisica
            if($_POST["tipo"] == 1){

                $customer = [
                    'name' => $_POST["nome_cliente"],
                    'cpf' => $_POST["cpf"],
                    'phone_number' => $_POST["telefone"]
                ];

            } else {

                $juridical_data = [
                  'corporate_name' => $_POST["nome_razao"], // nome da razão social
                  'cnpj' => $_POST["cnpj"] // CNPJ da empresa, com 14 caracteres
                ];
                
                $customer = [
                    'phone_number' => $_POST["telefone"],
                    'juridical_person' => $juridical_data
                ];
                
            }

            // Formatando a data, convertendo do estino brasileiro para americano.
           // $data_brasil = DateTime::createFromFormat('d/m/Y', $_POST["vencimento"]);
		   // 'expire_at' => $data_brasil->format('Y-m-d'),

            $bankingBillet = [
                'expire_at' => $_POST["vencimento"],
                'customer' => $customer
            ];
            $payment = ['banking_billet' => $bankingBillet];
            $body = ['payment' => $payment];

            $api = new Gerencianet($options);
            $pay_charge = $api->payCharge($params, $body);
            echo json_encode($pay_charge);
        } else {

        }
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}