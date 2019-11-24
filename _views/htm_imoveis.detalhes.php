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
    
    <!--start Facebook Open Graph Protocol-->
    <meta property="og:site_name" content="<?=$_base['titulo_pagina']?>" />
    <meta property="og:title" content="<?=$data->titulo?>" />
    <meta property="og:image" content="<?=$imagem_principal?>"/>
    <meta property="og:url" content="<?=DOMINIO?>imoveis/detalhes/id/<?=$data->id?>"/>
    <!--end Facebook Open Graph Protocol-->

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

    <style>

    .owl-prev{
        position: absolute !important;
        top: 45% !important;
        left: 10px !important;
        width: 35px !important;
        height: 35px !important;
        background-image: url(<?=LAYOUT?>img/prev.svg) !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: cover !important;
    }

    .owl-next{
        position: absolute !important;
        top: 45% !important;
        right: 10px !important;
        width: 35px !important;
        height: 35px !important;
        background-image: url(<?=LAYOUT?>img/next.svg) !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: cover !important;
    }

    .imoveis_imagens_div_min .owl-prev{
        position: absolute !important;
        top: 10px !important;
        left: -50px !important;
        width: 35px !important;
        height: 35px !important;
        background-image: url(<?=LAYOUT?>img/prev.svg) !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: cover !important;
    }
    
    .imoveis_imagens_div_min .owl-next{
        position: absolute !important;
        top: 10px !important;
        right: -50px !important;
        width: 35px !important;
        height: 35px !important;
        background-image: url(<?=LAYOUT?>img/next.svg) !important;
        background-repeat: no-repeat !important;
        background-position: center !important;
        background-size: cover !important;
    }

</style>

</head>
<body>

	<?=ANALYTICS?>

    <?php include_once('htm_modal.php'); ?>

    <?php include_once('htm_topo.php'); ?>

    <div id="conteudo_pagina2" class="conteudo_pagina2" >

        <div class='imoveis_detalhes'>

            <div class="container">
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-7">

                        <div class="row">

                            <div class="col-xs-12 col-sm-9 col-md-10">
                                <div class='imoveis_detalhes_titulo' ><?=$data->titulo?></div>
                                <div class='imoveis_detalhes_subtitulo'><?=$data->bairro?> | <span><?=$data->cidade?> - <?=$data->uf?></span></div>
                            </div>

                            <div class="col-xs-12 col-sm-3 col-md-2">
                                <div class="detalhes_favorito">

                                </div>
                            </div>

                        </div>

                        <div class="imoveis_imagens_div" >

                            <div class="owl-carousel detalhes_imagens" >
                                <?php
                                
                                foreach ($imagens as $key => $value) {

                                    echo "
                                    <div class='item' data-hash='img_".$value['id']."' >
                                    <div class='imoveis_detalhes_imagens' style='background-image:url(".$value['imagem_g'].");' >                                             
                                    </div>
                                    </div>
                                    ";

                                }

                                if(count($imagens) == 0){
                                    echo "
                                    <div class='item' data-hash='img_1' >
                                    <div class='imoveis_detalhes_imagens' style='background-image:url(".LAYOUT."img/semimagem.png);' >                                             
                                    </div>
                                    </div>
                                    ";
                                }
                                
                                ?>   
                            </div>

                        </div>

                        <div class="imoveis_imagens_div_min" >

                            <div class="owl-carousel detalhes_imagens_miniaturas" >
                                <?php

                                foreach ($imagens as $key => $value) {

                                    echo "
                                    <div class='item' >
                                    <div class='imoveis_detalhes_imagens_min' style='background-image:url(".$value['imagem_p'].");' >
                                    <a href='#img_".$value['id']."' ><img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;'></a>                                     
                                    </div>
                                    </div>
                                    ";

                                }
                                
                                ?>
                            </div>

                        </div>


                        <div class="social" >

                            <div class='social_titulo' >
                                Gostou? Compartilhe!
                            </div>
                            <ul>
                                <li>
                                    <a href="http://www.facebook.com/sharer.php?u=<?=$endereco_postagem?>" class="facebook" target="_blank" title="Compartilhar via Facebook"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="http://twitter.com/intent/tweet?text=<?=$data->titulo?>&url=<?=$endereco_postagem?>" class="twitter" target="_blank" title="Compartilhar via Twitter"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://plus.google.com/share?url=<?=$endereco_postagem?>" target="_blank" class="googleplus" title="Compartilhar via Google+"><i class="fa fa-google-plus"></i></a>
                                </li>
                            </ul>

                        </div>


                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-5">

                        <div class="imoveis_detalhes_quadro" >
                            <div class='padding' >

                                <div class="row">

                                    <div class="col-xs-12 col-sm-7 col-md-7">
                                        <div class="imoveis_detalhes_categoria">
                                            <?php
                                            if($data->categoria_id == 5279){
                                                echo "Imóvel para Venda";
                                            } else {
                                                echo "Imóvel para Locação";
                                            }
                                            ?>
                                        </div>
                                        <div class="imoveis_detalhes_titulo2"><?=$data->titulo?></div>                                     
                                    </div>

                                    <div class="col-xs-12 col-sm-5 col-md-5">
                                        <div class="imoveis_detalhes_ref" >Ref. <?=$data->ref?></div>
                                        <div class="imoveis_detalhes_valor" >R$ <?=$valor?></div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        <?php if($data->iptu > 0){ ?>
                                            <div class="imoveis_detalhes_area" >IPTU: R$ <?=$iptu?></div>
                                        <?php } ?>                                        
                                        <div class="imoveis_detalhes_ref2" >Ref. <?=$data->ref?></div>
                                        <?php if($data->area_total){ ?>
                                            <div class="imoveis_detalhes_area" >Área Total: <?=$data->area_total?></div>
                                        <?php } ?>
                                        <?php if($data->area_util){ ?>
                                            <div class="imoveis_detalhes_area" >Área Útil: <?=$data->area_util?></div>
                                        <?php } ?>
                                        <?php if($data->condominio){ ?><div class="imoveis_detalhes_condominio" >Condomínio: R$ <?=$condominio?></div><?php } ?>
                                        <?php if($data->quartos){ ?><div class="imoveis_detalhes_dormitorios" >Dormitorios: <?=$data->quartos?></div><?php } ?>
                                        <?php if($data->suites){ ?><div class="imoveis_detalhes_suites" >Sendo <?=$data->suites?> suite(s)</div><?php } ?>
                                        <div class="imoveis_detalhes_descricao" ><?=$data->descricao?></div>
                                        
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class='merda_1' >
                            <div class="imoveis_detalhes_quadro" >
                                <div class="padding" >
                                    <div class="imoveis_detalhes_quadro_ico2">
                                        <a href="#" class="hvr-grow" onClick="modal('<?=DOMINIO?>faleconosco/desejo/id/<?=$data->id?>');" ><img src="<?=LAYOUT?>img/detalhes_ico_desejo.svg" ></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='merda_2' >
                            <div class="imoveis_detalhes_quadro" >
                                <div class="padding" >
                                    <div class="imoveis_detalhes_quadro_ico2">
                                        <a href="#" onClick="history.go(-1)"; class="hvr-grow" ><img src="<?=LAYOUT?>img/detalhes_ico_voltar.svg" ></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="clear:both;"></div>

                    </div>

                </div>
            </div>

            <div style="background-color:#fff; margin-top:60px; padding-bottom:70px; padding-top:40px;">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div><h2 class="destaque_titulo" >Imóveis Similares</h2></div>

                            <div class="owl-carousel similares" >
                                <?php

                                foreach ($similares as $key => $value) {

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

    <script>

        $(document).ready(function(){

            var owl_detalhes = $('.detalhes_imagens');
            owl_detalhes.owlCarousel({
                autoplay: false,
                nav: true,
                navText:["", ""],
                dots: false,
                margin: 0,
                loop: false,
                URLhashListener:true,
                startPosition: 'URLHash',
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }        
                }
            });
            var owl_detalhes_min = $('.detalhes_imagens_miniaturas');
            owl_detalhes_min.owlCarousel({
                autoplay: false,
                nav: true,
                navText:["", ""],
                dots: false,
                margin: 5,
                loop: false,
                URLhashListener: true,
                autoplayHoverPause: true,
                startPosition: 'URLHash',
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 6
                    },
                    1000: {
                        items: 6
                    }
                }
            });
            var owl = $('.similares');
            owl.owlCarousel({
                autoplay: true,
                autoplayTimeout: 7000,
                nav: false,
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

            calcula_favoritos();

        });

    </script>

</body>
</html>

<?php include_once('htm_chat.php'); ?>