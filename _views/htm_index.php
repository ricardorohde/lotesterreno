<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$_base['titulo_pagina']?></title>
    <link rel="shortcut icon" href="<?=$_base['favicon'];?>">

    <meta name="description" content="<?=$_base['descricao']?>" />
    <meta property="og:description" content="<?=$_base['descricao']?>">
    <meta name="author" content="mrcomerciodigital.site">
    <meta name="classification" content="Website" />
    <meta name="robots" content="index, follow">
    <meta name="Indentifier-URL" content="<?=DOMINIO?>" />
    
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/font-awesome-4.6.2/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/animate/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-select/dist/css/bootstrap-select.css">
    <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-slider-master/dist/css/bootstrap-slider.css">
    <link rel="stylesheet" href="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,900,700,300,300italic,400italic,500,500italic,700italic,900italic' rel='stylesheet' type='text/css'>    

    <?php include_once('htm_css.php'); ?>
    <?php include_once('htm_css_resp.php'); ?>

</head>
<body>

	<?=ANALYTICS?>

    <?php include_once('htm_modal.php'); ?>
    
    <?php include_once('htm_topo.php'); ?>

    <div id="slideshow" class="slideshow slideshow_resp" >
        <?php

        $n = 0;
        foreach($banner_principal as $key => $value){

            if($n == 0){ $active = "class='active';"; } else { $active = ''; }

            echo "<div style='background-image:url(".$value['imagem'].");' $active ></div>";

            $n++;
        }

        ?>
    </div>

    <?php include_once('htm_busca.php'); ?>

    <style>

</style>

<div id="conteudo_pagina1" class="conteudo_pagina1" >

    <div class="imoveis_comprar" >
        <div class="container" >
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div><h2 class="destaque_titulo" >Imóveis em Destaque <strong>para Comprar</strong></h2></div>

                    <div class="owl-carousel destaques_comprar" >
                        <?php
                        
                        foreach($lista_venda as $key => $value) {

                            // sem favorito
                            $fav = "<a class='botao_favoritos' href='".DOMINIO."imoveis/add_fav/".$value['codigo']."' ><i class='fa fa-heart' aria-hidden='true' ></i></a>";
                            // com favorito
                            //$fav = "<a class='botao_favoritos ativo' href='".DOMINIO."fav/remover/$data->codigo' ><i class='fa fa-heart' aria-hidden='true' ></i></a>";

                            echo "
                            <div class='item' >
                            <div class='imovel_quadro' >

                            <div class='imovel_titulo' onClick=\"window.location='".$value['endereco']."';\" >".$value['titulo']."</div>
                            
                            <div class='imovel_imagem_div'>
                            <div class='imovel_valor' >R$ ".$value['valor']."</div>
                            <div class='imovel_imagem hvr-grow' style='background-image:url(".$value['imagem_principal'].");' >
                            <a href='".$value['endereco']."'><img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;'></a>
                            </div>
                            </div>
                            <div class='imovel_endereco' >
                            <div>".$value['bairro']."</div>
                            <div>".$value['cidade']." - ".$value['uf']."</div>
                            </div>
                            <div class='imovel_botao' onClick=\"window.location='".$value['endereco']."';\" >
                            <i class='fa fa-plus-circle' aria-hidden='true'></i> Detalhes
                            </div>
                            <div style='clear:both'></div>

                            </div>
                            </div>
                            ";

                        }

                        ?>
                    </div>

                    <div class="linha_destaques" >

                        <div class="esq" >
                            <a href="<?=DOMINIO?>imoveis/lista/referencia/comprar"><span><i class="fa fa-search" aria-hidden="true"></i></span> Ver todos os imóveis (<?=$total_venda?>)</a>
                        </div>

                        <div class="dir" >
                            
                        </div>

                        <div style="clear:both"></div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="imoveis_alugar" >
        <div class="container">
            <div class="row">                
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div><h2 class="destaque_titulo" >Imóveis em Destaque <strong>para Alugar</strong></h2></div>

                    <div class="owl-carousel destaques_comprar" >
                        <?php
                        
                        foreach($lista_locacao as $key => $value) {

                            // sem favorito
                            $fav = "<a class='botao_favoritos' href='".DOMINIO."imoveis/add_fav/".$value['codigo']."' ><i class='fa fa-heart' aria-hidden='true' ></i></a>";
                            // com favorito
                            //$fav = "<a class='botao_favoritos ativo' href='".DOMINIO."fav/remover/$data->codigo' ><i class='fa fa-heart' aria-hidden='true' ></i></a>";

                            echo "
                            <div class='item' >
                            <div class='imovel_quadro' >

                            <div class='imovel_titulo' onClick=\"window.location='".$value['endereco']."';\" >".$value['titulo']."</div>
                            
                            <div class='imovel_imagem_div'>
                            <div class='imovel_valor' >R$ ".$value['valor']."</div>
                            <div class='imovel_imagem hvr-grow' style='background-image:url(".$value['imagem_principal'].");' >
                            <a href='".$value['endereco']."'><img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;'></a>
                            </div>
                            </div>
                            <div class='imovel_endereco' >
                            <div>".$value['bairro']."</div>
                            <div>".$value['cidade']." - ".$value['uf']."</div>
                            </div>
                            <div class='imovel_botao' onClick=\"window.location='".$value['endereco']."';\" >
                            <i class='fa fa-plus-circle' aria-hidden='true'></i> Detalhes
                            </div>
                            <div style='clear:both'></div>

                            </div>
                            </div>
                            ";

                        }

                        ?>
                    </div>

                    <div class="linha_destaques" >

                        <div class="esq" >
                            <a href="<?=DOMINIO?>imoveis/lista/referencia/alugar"><span><i class="fa fa-search" aria-hidden="true"></i></span> Ver todos os imóveis (<?=$total_locacao?>)</a>
                        </div>

                        <div class="dir" >
                             
                        </div>

                        <div style="clear:both"></div>

                    </div>

                </div>                
            </div>
        </div>
    </div>

    <?php include_once('htm_subrodape.php'); ?>

    <?php include_once('htm_rodape.php'); ?>

</div>

<script src="<?=LAYOUT?>api/jquery/jquery-1.12.3.min.js"></script>
<script src="<?=LAYOUT?>api/bootstrap/bootstrap.min.js"></script> 
<script src="<?=LAYOUT?>api/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?=LAYOUT?>api/bootstrap-slider-master/dist/bootstrap-slider.min.js"></script>
<script src="<?=LAYOUT?>api/OwlCarousel2-2.3.4/dist/owl.carousel.min.js"></script>
<script src="<?=LAYOUT?>api/js_mascaras/mascaras.js"></script>
<script src="<?=LAYOUT?>js/geral.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>

<script type="text/javascript">

    function carrega_bairros(cidade){
        var endereco_arquivo = dominio()+'imoveis/bairros';
        $.post(endereco_arquivo, {cidade: cidade},function(data){
            if(data){
                $('#bairros_lista').html(data);
            }        
        });
    }

    function carrega_bairros_principal(cidade){
        var endereco_arquivo = dominio()+'imoveis/bairros_principal';
        $.post(endereco_arquivo, {cidade: cidade},function(data){
            if(data){
                $('#bairros_lista_principal').html(data);
            }
        });
    }
    carrega_bairros_principal('<?=CIDADE?>');

    function troca_faixa_preco(tipo){
        if(tipo == 'alugar'){
            $('#preco_alugar').show();
            $('#preco_comprar').hide();
        } else {
            $('#preco_alugar').hide();
            $('#preco_comprar').show();
        }
    }

    function favoritos(codigo){

        $('#imovel_fav_'+codigo).html("<img src='<?=LAYOUT?>img/loading.gif' style='width:15px;' >");

        var endereco_arquivo = dominio()+'fav';
        $.post(endereco_arquivo, {codigo: codigo}, function(data){
            if(data){
                if(data == 'inativo'){
                    $('#imovel_fav_'+codigo).html("<a class='botao_favoritos' onClick=\"favoritos('"+codigo+"');\"; ><i class='fa fa-heart' aria-hidden='true' ></i></a>");
                } else {
                    $('#imovel_fav_'+codigo).html("<a class='botao_favoritos ativo' onClick=\"favoritos('"+codigo+"');\";  ><i class='fa fa-heart' aria-hidden='true' ></i></a>");
                }
            }
            calcula_favoritos();
        });

    }

    function slideSwitch() {
        var $active = $('#slideshow DIV.active');

        if ( $active.length == 0 ) $active = $('#slideshow DIV:last');

        var $next =  $active.next().length ? $active.next()
        : $('#slideshow DIV:first');

        $active.addClass('last-active');

        $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
    }
    setInterval("slideSwitch()", 3000);

    function calcula_favoritos(){ 
        $('.variavel_favoritos').html(0); // provisorio ate conferir toda parte de cokies
    }
    calcula_favoritos();

    ///////////////////////////////////////////////////////////////
    
    $(function(){

        var slider = new Slider('#alugar_busca_principal_valor', {
            tooltip: 'hide'
        });

        $("#alugar_busca_principal_valor").on("slide", function(slideEvt) {

            var resultado = slideEvt.value;

            var valor_min = numeroParaMoeda(resultado[0]);
            var valor_max = numeroParaMoeda(resultado[1]);

            if(valor_max == '15.000,00'){
                valor_max = 'MÁXIMO';
            } else {             
                valor_max = 'R$ '+valor_max;
            }

            if(valor_min == '0,00'){
                valor_min = 'MÍNIMO';
            } else {             
                valor_min = 'R$ '+valor_min;
            }

            $("#alugar_valor_min").val(valor_min);
            $("#alugar_valor_max").val(valor_max);

        });

        var slider = new Slider('#comprar_busca_principal_valor', {
            tooltip: 'hide'
        });

        $("#comprar_busca_principal_valor").on("slide", function(slideEvt) {

            var resultado = slideEvt.value;

            var valor_min = numeroParaMoeda(resultado[0]);
            var valor_max = numeroParaMoeda(resultado[1]);

            if(valor_max == '1.500.000,00'){
                valor_max = 'MÁXIMO';
            } else {
                valor_max = 'R$ '+valor_max;
            }

            if(valor_min == '0,00'){
                valor_min = 'MÍNIMO';
            } else {             
                valor_min = 'R$ '+valor_min;
            }

            $("#comprar_valor_min").val(valor_min);
            $("#comprar_valor_max").val(valor_max);

        }); 

        var owl = $('.destaques_comprar');
        owl.owlCarousel({
            autoplay: true,
            autoplayTimeout: 7000,
            nav: true,
            navText:["", ""],
            dots: true,
            margin: 50,
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });

        var owl = $('.destaques_alugar');
        owl.owlCarousel({
            autoplay: true,
            autoplayTimeout: 7000,
            nav: true,
            navText:["", ""],
            dots: true,
            margin: 50,
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });

    });

</script>
</body>
</html>


<?php include_once('htm_chat.php'); ?>