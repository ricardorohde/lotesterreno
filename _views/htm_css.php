<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<style type="text/css">

body {
	font-family: 'Roboto', sans-serif;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
	font-family: 'Roboto', sans-serif;
	font-weight: normal;
}

/*/////////////////////////////////////////////////////////////////*/

a#scrollUp {
	bottom: 0px;
	right: 10px;
	padding-left: 15px;
	padding-right: 15px;
	padding-top:10px;
	padding-bottom:10px;
	background: <?=$_base['cor'][1]?>;
	color: #fff;
	font-size: 20px;
	-webkit-animation: bounce 2s ease infinite;
	animation: bounce 2s ease infinite;
}

/*/////////////////////////////////////////////////////////////////*/

#slideshow {

}
.slideshow {
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 100%;
	z-index: 1;
}
#slideshow DIV{
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	background-size: cover;
	background-repeat: no-repeat;
	background-position: center;
	z-index:8;
}
#slideshow DIV.active{
	z-index:10;
	opacity:1.0;
}
#slideshow DIV.last-active {
	z-index:9;
}

/*/////////////////////////////////////////////////////////////////*/

#topo {
	position: absolute;
	left: 0px;
	top: 0px;
	width: 100%;
	height:120px;
	z-index:20;
	background-color: rgba(255,255,255,1.00);
}
.logo {
	margin-top:30px;
	text-align: left;
	width:255px;
}
.logo img {
	max-width: 100%;
}
.topo_menu_cima{
	width:100%;
	text-align:right;
	margin-top: 18px;
}
.topo_info {
	font-size: 14px;
	display: inline-block;
	margin-left:40px;
}
.topo_icones {
	font-size: 17px;
	color:<?=$_base['cor'][1]?>;
}
.topo_info a{
	color: #000;
}
#menu_fundo {
	position: absolute;
	bottom: 0px;
	right:0px;
	background-color: <?=$_base['cor'][1]?>;
	width: 65%;
	height: 60px;
}
#menu {	
	width: 100%;
	margin-top:40px;
}
#menu ul{
	list-style: none;
	display: block;
	text-align: right;
}
#menu ul li{
	list-style: none;
	display: inline-block;
	font-size: 14px;
	color: #000;
	margin-left:25px;
}
#menu ul li a{
	color:<?=$_base['cor'][2]?>; 
}

#menu_responsivo_botao{
	position: absolute;
	right: 20px;
	top: 50%;
	margin-top:-15px;
	display: none;
	color: #999;
	width: 30px;
	height: 30px;
	border-radius: 30px;
	border:2px solid #999;
	padding-top: 3px;
	font-size: 15px;
	text-align: center;
	z-index: 99999;
}
#menu_responsivo_botao:hover {
	cursor: pointer;
	color:#ccc;
}

#menu_responsivo {
	display: none;
	position: absolute;
	z-index: 99999999999;
	left: 0px;
	top: 100px;
	background-color: rgba(0,0,0,0.9);
	width: 100%;
	height: auto;
	text-align: center;
	padding-top: 10px;
	padding-bottom: 20px;
}
#menu_responsivo ul{
	list-style: none;
	margin: 0px;
	padding: 0px;
}
#menu_responsivo ul li{
	list-style: none;
	font-size: 16px;
	color: #FFF;
	margin: 0px;
	padding: 0px;
	margin-top: 10px;
}
#menu_responsivo ul li a{
	color:#FFF;
}


/*/////////////////////////////////////////////////////////////////*/

.slogan {
	font-size: 50px;
	color: #FFF;
	text-shadow: black 0.0em 0.0em 0.2em;
	font-weight: 400;
}

/*///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

#busca_principal {
	position: absolute;
	top:37%;
	left: 0px;
	width: 100%;
	height: auto;
	z-index: 999;
	text-align: center;
}
.busca_principal_quadro{
	width: 60%;
	border-radius: 10px;
	display: inline-block;
	margin-top: 20px;
}

.tab-pane{
	padding: 25px 25px 25px 25px;
	background-color: rgba(0,0,0,0.7);
	border: 0px;
	border-radius: 0px 5px 5px 5px;
}
.nav-tabs {
	border:0px;
}
.nav-tabs>li {
	margin-bottom: 0px;
} 
.nav-tabs>li>a {
	background-color: rgba(0,0,0,0.4);
	border: 0px;
	color: #FFF;
	font-size: 16px;
}
.nav-tabs>li>a:hover {
	background-color: rgba(0,0,0,0.6);
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus {
	background-color: rgba(0,0,0,0.7);
	border: 0px;
	color:#fff;
	font-size: 16px;
}

.busca_principal_campo_div{
	float: left;
	width: 20%;
}
.busca_principal_campo_div2{
	float: left;
	width: 75%;
}
.busca_principal_campo_div3{
	float: left;
	width: 25%;
}
.busca_principal_campo_txt{
	font-size:14px;
	color:#FFF;
	text-align: left;
	padding-bottom: 8px;
}
.busca_numero_imoveis{
	display: block;
	color:#FFF;
	text-align: left;
	font-size: 14px;
	padding-top: 8px;
}

.busca_principal_quadro .btn {
	width:100%;
	padding: 15px 12px;     
	font-size: 16px;
	font-weight: 500;
	margin: 0px;
	border-radius: 0px;
}
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
	width: 100%;
}
#busca_principal .bootstrap-select.btn-group .dropdown-menu li a {
	font-size: 16px;
	font-weight: 500;
}
#busca_principal .input-group-btn:last-child>.btn {
	margin-left: 0px;
}

#detalhada .btn {
	padding: 7px 10px 5px 10px;
}
#detalhada .bootstrap-select.btn-group .dropdown-toggle .filter-option {
	font-size: 14px;
}
#detalhada .bootstrap-select.btn-group .dropdown-menu li a {
	font-size: 14px;
}

.botaozao {
	width:25%;
	background: <?=$_base['cor'][1]?>;
	border:1px solid <?=$_base['cor'][1]?>;
	border-radius: 0px 5px 5px 0px;
	color: <?=$_base['cor'][2]?>;
}
.botaozao:hover {
	background: <?=$_base['cor'][1]?>;
	border:1px solid #f3ac00;
	color: <?=$_base['cor'][2]?>;
}
.form_referencia{
	border: 0px;
	background: #FFF;
	padding-left: 20px;
	height: 54px;
	font-size: 15px;
	text-align: left;
	border-radius: 0px;
}

/*/////////////////////////////////////////////////////////////////*/

.slider.slider-horizontal {
	width: 100%;
}
.slider.slider-horizontal .slider-track {
	background:rgba(255,255,255,0.6);
	height: 6px;
}
.slider.slider-horizontal .slider-tick, .slider.slider-horizontal .slider-handle {
	margin-top: -7px;
}
.slider-handle {
	border: 5px solid <?=$_base['cor'][1]?>;
	background: #FFF;
}
.slider-selection {
	background: #FFF;
}

/*/////////////////////////////////////////////////////////////////*/

.conteudo_pagina1{
	position: absolute;
	left: 0px;
	top:100%;
	width: 100%;
}
.conteudo_pagina2{
	position: absolute;
	left: 0px;
	top:120px;
	width: 100%;
}

/*/////////////////////////////////////////////////////////////////*/



.acesso_rapido div {
	padding-bottom: 2px;
}
.acesso_rapido a {
	color: #FFF;
	font-size: 14px;
}
.acesso_rapido a:hover {
	text-decoration: underline;
}

.atendimento div {
	padding-bottom: 2px;
}
.atendimento a {
	color: #FFF;
	font-size: 14px;
}
.atendimento a:hover {
	text-decoration: underline;
}

.cadastro_email {

}
.cadastro_email .botao{
	width: 100%;
	background: <?=$_base['cor'][1]?>;
	border:1px solid <?=$_base['cor'][1]?>;
	font-weight: bold;
	color:<?=$_base['cor'][2]?>;
}
.facebook_titulo{
	font-size: 14px;
	color: #FFF;
	padding-bottom: 10px;
	padding-top: 20px;
	font-weight: 200;
}
.facebook img{
	width: 150px;
}

/*/////////////////////////////////////////////////////////////////*/

.copyright{
	text-align:center;
	padding-top:20px;
	padding-bottom:35px;
	color:<?=$_base['cor'][80]?>;
	font-size: 13px;
}
.copyright a {
	color: <?=$_base['cor'][80]?>;
}
.copyright a:hover {
	text-decoration: underline;
}





/*/////////////////////////////////////////////////////////////////*/

.destaque_titulo {
	color:#666;
	font-size: 25px;
	text-align: center;
	padding-bottom: 35px;
}
.imovel_quadro {
	width: 100%;
	height: 310px;
	overflow: hidden;
	border-radius: 5px;
	border: 1px solid #f2f2f2;
}
#busca .imovel_quadro {
	margin-top: 20px;
	position: relative;
}
.imovel_titulo{
	font-size: 14px;
	text-align: left;
	padding-left:15px;
	padding-top: 12px;
	padding-bottom: 8px;
	float: left;
	font-weight: 500;
	cursor: pointer;
}
.imovel_titulo:hover{
	text-decoration: underline;
}
.imovel_fav{
	float: right;
	font-size: 16px;
	padding-left:15px;
	padding-right:15px;
	padding-top: 12px;
	padding-bottom: 8px;
}

.botao_favoritos {
	color:#CCC;
	cursor: pointer;
}
.botao_favoritos:hover{
	color:#E00000;
}
.imovel_fav .ativo {
	color:#E00000;
}

.imovel_imagem_div{
	width: 100%;
	height: 200px;
	overflow: hidden;
}
.imovel_imagem{
	clear: both;
	width: 100%;
	height: 200px;
	background-size: cover;
	background-position: center;
	background-repeat: no-repeat;
	cursor: pointer;
}
.imovel_valor {
	position: absolute;
	top: 55px;
	left: 15px;
	padding-top:5px;
	padding-bottom: 3px;
	padding-left: 12px;
	padding-right: 12px;
	font-size: 14px;
	font-weight: 500; 
	text-align: center;
	color:#FFF;
	z-index: 999;
	background-color: rgba(0,0,0,0.6);
}
.imovel_endereco{
	font-size: 14px;
	text-align: left;
	padding-left:15px;
	padding-top: 12px;
	padding-bottom: 10px;
	float: left;
}
.imovel_botao{
	float: right;
	font-size: 13px;
	margin-left:15px;
	margin-right:15px;
	margin-top: 15px;
	margin-bottom: 10px;
	cursor: pointer;	
	background-color: #fff;
	border: 1px solid #999;
	color: #999;
	padding-top: 7px;
	padding-bottom: 7px;
	padding-left: 15px;
	padding-right: 15px;
	border-radius: 3px;
}
.imovel_botao:hover{
	color: #333;
	background-color: <?=$_base['cor'][1]?>;
	border: 1px solid <?=$_base['cor'][1]?>;
}
.linha_destaques{
	margin-top:20px;
	padding-top: 12px;
	border-top: 1px solid #CCC;
	color: #666;
}
.linha_destaques .esq{
	float: left;
}
.linha_destaques .dir{
	float: right;
}
.linha_destaques a{
	color: #666;
}
.linha_destaques .esq span{
	color: <?=$_base['cor'][1]?>;
}
.linha_destaques .dir .coracao {
	color: #E00000;
}


.imoveis_comprar {
	width: 100%;
	background-color: #f5f5f5;
	padding-top: 50px;
	padding-bottom: 80px;
}
.imoveis_comprar_lista {
	padding-top: 10px;
	margin-top: 20px;
	padding-bottom:20px;
}
.imoveis_comprar .imovel_quadro {
	background-color: #FFF;
}
.imoveis_comprar .imovel_valor {
	background-color: #008b06;
}


.imoveis_alugar {
	width: 100%;
	background-color: #FFF;
	padding-top: 50px;
	padding-bottom:80px;
}
.imoveis_alugar_lista {
	margin-top: 20px;
	padding-top: 0px;
	padding-bottom:20px;
}

.imoveis_alugar .imovel_quadro {
	background-color: #f5f5f5;
}
.imoveis_alugar .imovel_valor {
	background-color: #356CB8;
}

/*/////////////////////////////////////////////////////////////////*/

.imoveis_detalhes{
	background-color: #f5f5f5;
	padding-top: 65px;
}

.imoveis_detalhes_titulo{
	font-size: 20px;
	color: #666;

}
.imoveis_detalhes_titulo2{
	font-size: 18px;
	color: #666;
	padding-left: 15px;
	font-weight: 500;
}
.imoveis_detalhes_subtitulo{
	font-size: 20px;
	color: #666;
}
.imoveis_detalhes_subtitulo span{
	font-weight: bold;
}

.imoveis_detalhes_quadro{
	background-color: #fff;
	border:1px solid #e6e6e6;
	border-radius: 5px;
	width: 100%;
}
.imoveis_detalhes_quadro .padding{
	padding: 20px;
}
.imoveis_detalhes_quadro_linha{
	border-top: 1px solid #CCC;
	margin-top: 30px;
}
.imoveis_detalhes_categoria{
	color: #666;
	font-size: 18px;
	padding-left: 15px;
	font-weight: 500;
}
.imoveis_detalhes_valor{
	background-color: #4CAF50;
	padding-top: 5px;
	padding-bottom: 5px;
	padding-left: 15px;
	padding-right: 15px;
	font-size: 16px;
	font-weight: bold;
	color: #FFF;
	text-align: center;
	border-radius: 4px;
}
.imoveis_detalhes_ref{
	font-size: 16px;
	color: #666;
	text-align: right;
	padding-bottom: 5px;
}
.imoveis_detalhes_ref2{
	font-size: 14px;
	color: #666;
	text-align: left;
	padding-top: 20px;
	padding-left: 15px;
	display: none;
}
.imoveis_detalhes_quadro_ico{
	padding-top: 30px;
	text-align: left;
}
.imoveis_detalhes_quadro_ico2{
	text-align: left;
}
.imoveis_detalhes_quadro_ico img{
	height: 65px;
}
.imoveis_detalhes_quadro_ico2 img{
	height: 30px;
}
.merda_1{
	float:left; width:65%; margin-top:20px;
}
.merda_2{
	float:left; width:35%; margin-top:20px;
}

.imoveis_detalhes_area{
	font-size: 14px;
	color: #666;
	padding-left: 15px;
	padding-top: 10px;
}
.imoveis_detalhes_condominio{
	font-size: 14px;
	color: #666;
	padding-left:15px;
	padding-top: 10px;
}
.imoveis_detalhes_dormitorios{
	font-size: 14px;
	color: #666;
	padding-left:15px;
	padding-top: 10px;
}
.imoveis_detalhes_suites{
	font-size: 14px;
	color: #666;
	padding-left:15px;
	padding-top: 10px;
}
.imoveis_detalhes_descricao{
	font-size: 14px;
	color: #666;
	padding-left:15px;
	padding-top: 20px;
} 

.imoveis_imagens_div{
	margin-top: 20px;
	width: 100%;
}
.imoveis_detalhes_imagens{
	width: 100%;
	height: 400px;
	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
	border-radius: 4px;
}
.imoveis_imagens_div_min{
	padding-top: 10px;
	margin-left: 50px;
	margin-right: 50px;
}
.imoveis_detalhes_imagens_min{
	width: 100%;
	height: 60px;
	background-repeat: no-repeat;
	background-position: center;
	background-size: cover;
	cursor: pointer;
	border-radius: 3px;
}
.detalhes_imagens_miniaturas{
	margin-bottom: 30px;
}

.detalhes_favorito{
	width: 100%;
	text-align: right;
	padding-top: 20px;
}
.detalhes_favorito a {
	font-size:23px;
	color:#ccc;
}
.detalhes_favorito a.ativo{
	color:#E00000;
}

/*/////////////////////////////////////////////////////////////////*/

.pagination li a, .pagination li span {
	background-color:#fff;
	color:#666;
}
.pagination li span {
	background-color: transparent;
}
.pagination li a:hover {
	background-color:#f2f2f2;
	color:#666;
}
.pagination li a.active{
	background-color:#f1f1f1;
	color:#000;
}
.pagination li a.setasperso{
	padding: 0px;
	padding-right: 10px;
}
.pagination li span:hover{
	color:#666;
}

.paginacao_seta_left{
	font-size: 16px;
	padding: 6px 13px 4px 11px !important;
}
.paginacao_seta_right{
	font-size: 16px;
	padding: 6px 11px 4px 13px !important;
}

/*/////////////////////////////////////////////////////////////////*/

.modal_texto{
	font-size: 14px;
	color:#666;
	padding-bottom: 5px;
	margin-top: 10px;
}
.modal_input_div {

}
.modal_input{
	border:1px solid #ccc;
	border-radius: 4px;
	font-size: 14px;
	padding: 8px;
}
.bancos{
	display: inline-block;
	margin-right:5px;
	margin-bottom:10px;
	width: 32%;
}
.bancos img{
	width: 100%;
}

/*/////////////////////////////////////////////////////////////////*/

.institucional_img{
	padding-top:50px; padding-bottom:50px; width:100%; text-align:right; 
}
.institucional_img img { 
	width:80%;
}

/*/////////////////////////////////////////////////////////////////*/

#filtros{
	display: none;
	padding-top: 20px;
}
.filtros_div{
	margin-top:20px;
}
.filtros_div2{
	margin-top:40px;
	text-align: right;
}
.filtros_div3{
	margin-bottom:10px;
	text-align: left;
}
.filtros_div4{
	margin-top:23px;
	text-align: left;
}
.filtros_campo_txt{
	font-size: 13px;
	padding-bottom: 2px;
}
#busca_principal .filtros_campo_txt{
	color:#FFF;
	text-align: left;
	padding-bottom: 5px;
}

.faixa_preco_div{
	width: 40%;
	float: left;
}
.faixa_preco_div2{
	padding-top: 10px;
}
.faixa_preco_div_txt{
	width: 20%;
	float: left;
	text-align: center;
}
#detalhada .faixa_preco_div_txt{
	color: #FFF;
}
.faixa_preco_div input{
	width: 100%;
	border: 1px solid #ccc;
	text-align: center;
	border-radius: 4px;
	font-size: 12px;
}

.botaozinho {
	background: <?=$_base['cor'][1]?>;
	border:1px solid <?=$_base['cor'][1]?>;
	width: 100%;
	color:#fff;
}
.botaozinho:hover {
	background: #791a1c;
	border:1px solid #f3ac00;
	color:#fff;
}

/*/////////////////////////////////////////////////////////////////*/

.social{
	text-align: left;
}
.social_titulo{
	font-size: 16px;
	color:#666;
	padding-bottom: 10px;
}
.social ul {
	list-style: none;
	margin: 0px;
	padding:0px;
}
.social li {
	list-style: none;
	float: left;
	margin: 0px;
	padding:0px;
}
.social li a {
	display: inline-block;
	width: 40px;
	height: 40px;
	text-align: center;
	line-height: 40px;
	color: #fff;
	margin: 0 3px;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	-ms-border-radius: 2px;
	border-radius: 2px;
	font-size: 16px;
}
.social li a.facebook {
	background: #5370bb;
}
.social li a.twitter {
	background: #6bb8db;
}
.social li a.googleplus {
	background: #dd4b39;
}


#topo p {
	margin: 0px !important;
	padding: 0px !important;
	display: inline-block !important;
}

.central_cliente {
	position: relative;
}
.central_cliente_submenu {
	display: none;
	width: 100%;
	height: auto;
	position: absolute;
	top:0px;
	padding-top: 30px;
	left: 0px;
	text-align: center;
}
.central_cliente_submenu a{
	display: block;
	width:100%;
	text-decoration: none;
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: center;
	border:1px solid #666;
	background-color: #fff;
	font-size: 12px;
}
.central_cliente_submenu a:hover{
	background-color: #eee;
}
.central_cliente:hover .central_cliente_submenu {
	display: block;
}

.owl-prev{
	position: absolute;
	top: -74px !important;
	right: 40px !important;
	width: 35px !important;
	height: 35px !important;
	background-image: url(<?=LAYOUT?>img/prev.svg) !important;
	background-repeat: no-repeat !important;
	background-position: center !important;
	background-size: cover !important;
}
.owl-next{
	position: absolute;
	top: -74px !important;
	right: 0px !important;
	width: 35px !important;
	height: 35px !important;
	background-image: url(<?=LAYOUT?>img/next.svg) !important;
	background-repeat: no-repeat !important;
	background-position: center !important;
	background-size: cover !important;
}

.svg_icone1 {
	fill:#ffcb08;
}

.sub_rodape_titulo{
	font-size: 20px;
	color:#333;
	text-align: center;
	padding-top: 15px;
}
.sub_rodape_txt{
	font-size: 14px;
	color:#333;
	text-align: center;
	margin-top:15px;
}
.sub_rodape_botao{
	margin-top: 15px;
	border:1px solid #ffcb08;
	text-align: center;
	font-size: 13px;
	color:#333;
	border-radius: 4px;
	padding-top: 10px;
	padding-bottom: 8px;
	cursor: pointer;
	display: inline-block;
	width: 180px;
}
.sub_rodape_botao:hover{
	background-color: #ffcb08;
}
#sub_rodape {
	width: 100%;
	height: auto;
	background-image: url(<?=LAYOUT?>img/fundo_subrodape.jpg);
	background-repeat: no-repeat;
	background-position: bottom;
	padding-top: 80px;
	padding-bottom: 80px;
}



#rodape {
	width: 100%;
	background-color: <?=$_base['cor'][69]?>;
}
.rodape_titulo{
	font-size: 17px;
	color: <?=$_base['cor'][80]?>;
	padding-bottom: 15px;
	padding-top: 40px;
	font-weight: 200;
}
.rodape_telefone{
	color:<?=$_base['cor'][80]?>;
	font-size: 20px;
	margin-top: -3px;
}
.rodape_whatsapp{
	color:#FFF;
	font-size: 17px;
}
.rodape_linha{
	border-top: 1px solid #CCC;
	padding-top: 10px;
	margin-top: 30px;
}

.rodape_endereco{
	font-size: 15px;
	line-height: 24px;
	color:<?=$_base['cor'][80]?>;
}

</style>