<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Brazil/East");
define('TOKEN2', md5('tokendonavegador'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_name(md5('frasesecretadasessao'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_cache_expire(10);
session_start();

require_once('_config.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// definição para ssl
if($config['https']){
    if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) { } else {
        $new_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        echo "<script>window.location='$new_url';</script>";
        exit;
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definiçoes
if($_SERVER['HTTP_HOST'] == 'localhost'){
    define("SERVIDOR", $config['SERVIDOR_LOCAL']);
    define("USUARIO", $config['USUARIO_LOCAL']);
    define("SENHA", $config['SENHA_LOCAL']);
    define("BANCO", $config['BANCO_LOCAL']);
} else {
    define("SERVIDOR", $config['SERVIDOR']);
    define("USUARIO", $config['USUARIO']);
    define("SENHA", $config['SENHA']);
    define("BANCO", $config['BANCO']);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definiçoes de Pastas e ssl
if($config['https']){
    if($_SERVER['HTTP_HOST'] == 'localhost'){
        $config_dominio = "https://".$_SERVER['HTTP_HOST']."/".$config['PASTA_LOCAL']."/";
    } else {
        if($config['PASTA']){
            $config_dominio = "https://".$_SERVER['HTTP_HOST']."/".$config['PASTA']."/"; 
        } else {
            $config_dominio = "https://".$_SERVER['HTTP_HOST']."/";
        }
    }
} else {
    if($_SERVER['HTTP_HOST'] == 'localhost'){
        $config_dominio = "http://".$_SERVER['HTTP_HOST']."/".$config['PASTA_LOCAL']."/";
    } else {
        if($config['PASTA']){
            $config_dominio = "http://".$_SERVER['HTTP_HOST']."/".$config['PASTA']."/"; 
        } else {
            $config_dominio = "http://".$_SERVER['HTTP_HOST']."/";
        }
    }
}

define("DOMINIO", $config_dominio);
define("PASTA_CLIENTE", $config_dominio."sistema/arquivos/");
define("AUTOR", "mrcomerciodigital.site");

define("TOKEN", md5($config['TOKEN']) );
define("CONTROLLERS", '_controllers/'); 
define("VIEWS", '_views/');
define("MODELS", '_models/');
define("LAYOUT", DOMINIO.VIEWS);
define("ANALYTICS", $config['ANALYTICS']); 
define("CIDADE", $config['CIDADE']); 

require_once('_system/system.php');
require_once('_system/mysql.php');
require_once('_system/controller.php');
require_once('_system/model.php');

//carrega os models automaticamente
function auto_carregador($arquivo) {
    if(file_exists(MODELS.$arquivo.".php")){
      require_once(MODELS.$arquivo.".php");
    } else {
        echo "Erro: O Model '".$arquivo."' não foi encontrado!";
        exit;
    }
}
spl_autoload_register("auto_carregador");

$start = new system();
$start->run();