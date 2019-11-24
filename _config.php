<?php
$config = array();
/////////////////////////////////////////////////////////////////////////////////////////////////
// Configrações de base de dados do servidor (coloque aqui os dados do banco de dados MYSQL da sua hospedagem)
$config['SERVIDOR'] = "mysql669.umbler.com";
$config['USUARIO'] = "lotesterreno";
$config['SENHA'] = "Bruna2012*";
$config['BANCO'] = "lotesterreno";

/////////////////////////////////////////////////////////////////////////////////////////////////
// Configrações de base de dados local (apenas para trabalhar em ambiente local como xampp)
// se for utilizar em servidor web igone esta configuração
$config['SERVIDOR_LOCAL'] = "localhost:3309";
$config['BANCO_LOCAL'] = "lotesterreno";
$config['USUARIO_LOCAL'] = "root";
$config['SENHA_LOCAL'] = "";

/////////////////////////////////////////////////////////////////////////////////////////////////
// Configrações DE local
$config['CIDADE'] = 'Ubatuba';

/////////////////////////////////////////////////////////////////////////////////////////////////
// Configuração para certificado digital
$config['https'] = false; // true para sim, false para não

/////////////////////////////////////////////////////////////////////////////////////////////////
// Configrações de Pasta
$config['PASTA'] = ""; //caso os arquivos não fiquem na raiz da hospedagem e sim em uma pasta dentro do servidor
$config['PASTA_LOCAL'] = "public"; //caso utilize xampp para trabalhar local ficaria localhost/nome da pasta local

/////////////////////////////////////////////////////////////////////////////////////////////////
// Token
$config['TOKEN'] = ""; // qualquer palavra para gerar o token de segurança

/////////////////////////////////////////////////////////////////////////////////////////////////
// Google analytcs ou algum script que queira que carregue em todas as páginas do site
// coloque entre as aspas duplas ex: 
//
// $config['ANALYTICS'] = "  codigo ";
//
// lembrando que o codigo não pode conter aspas duplas dentro dele se tiver substitua por aspas simples 
//
// ex se tiver assim: 
// <script src=" endereco do script " ></script>
// alterar para
// <script src=' endereco do script ' ></script>
//
$config['ANALYTICS'] = "


";