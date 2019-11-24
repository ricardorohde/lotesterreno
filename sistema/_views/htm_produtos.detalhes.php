<?php require_once('_system/bloqueia_view.php'); ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?=$data->titulo?> - <?=$_base['titulo_pagina']?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>">

	<meta name="description" content="<?=$data->previa?>" />
	<meta property="og:description" content="<?=$data->previa?>">
	<meta name="author" content="NuvemServ.com.br">
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow">
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />
	
	<link href="<?=LAYOUT?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/prettyPhoto.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/price-range.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/animate.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/main.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/responsive.css" rel="stylesheet">
	<link href="<?=LAYOUT?>css/blog.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/page-nav.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/images.css" rel="stylesheet">
    <link href="<?=LAYOUT?>api/hover-master/css/hover-min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>css/personalizado.css" rel="stylesheet"> 
    
	<?php include_once('htm_css.php'); ?>
	
</head>

<body>

<?php // carrega o arquivo txt com o codigo do analytcs
echo ANALYTICS; ?>

<?php include_once('htm_modal.php'); ?>

<?php include_once('htm_topo.php'); ?>

<section>
        <div class="container">

        <div class="row">
            
            <div class='col-xs-12 col-sm-4 col-md-3'>
                
                <div style="padding-top:20px;"></div>

                <?php include_once('htm_categorias.php'); ?>
                
                <?php include_once('htm_banner_esquerda.php'); ?>

                <div style="padding-top:40px;"></div>

            </div>

            <div class='col-xs-12 col-sm-8 col-md-9'>

            <div style="padding-top:35px;"></div>

            <div class="produtos_detalhes_margin" >

                
                <h2 class="produto_detalhes_titulo" ><?=$data->titulo?></h2>

                <div class="product-details">

                    <div class="row">
                        
                        <div class="col-sm-7">

                            <div id="similar-product" class="carousel slide" data-ride="carousel">
                                
                                <div class="carousel-inner">
                                <?php

                                    $i = 0;
                                    foreach ($imagens as $key => $value) {

                                        if($i == 0){
                                            $active = " active";
                                        } else {
                                            $active = "";
                                        }

                                        echo "
                                        <div class='item$active' >
                                            <div class='produto_imagem_detalhes' style='background-image:url(".$value['imagem_g'].");' >
                                                <div class='produto_imagem_lupa' >
                                                    <a href='".$value['imagem_g']."' rel='prettyPhoto[galeria1]' ><img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;' ></a>
                                                </div>
                                            </div>
                                        </div>
                                        ";

                                    $i++;
                                    }
                                    

                                    if($i == 0){

                                        $imagem = LAYOUT."img/semimagem.png";

                                        echo "
                                        <div class='item active' >
                                            <div class='produto_imagem_detalhes' style='background-image:url($imagem);' ><a href='$imagem' rel='prettyPhoto[galeria1]' ><img src='".LAYOUT."img/transp.png' style='width:100%; height:100%;' ></a></div>
                                        </div>
                                        ";

                                    $i++;
                                    }

                                ?>
                                </div>

                                <?php if($i > 1){ ?>

                                <a class="left item-control" href="#similar-product" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right item-control" href="#similar-product" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>

                                <?php } ?>

                            </div>

                        </div>

                        <div class="col-sm-5">
                            <div class="product-information">
                            <form name="add_carrinho" id="add_carrinho" action="<?=DOMINIO?>carrinho/adicionar" method="post" >

                                <div class="produto_detalhes" >Cód. Produto: <strong><?=$data->ref?></strong></div>
                                
                                <hr>
                                
                                <?php

                                    $mostra = "";                                    
                                    foreach ($tamanhos as $key => $value) {

                                        $mostra .= "<option value='".$value['codigo']."' rel='".$value['valor']."' >".$value['titulo']."</option>";

                                    }
                                    
                                if($mostra){
                                
                                ?>
                                <div class="produto_detalhes" >Tamanho:</div>
                                <div style="padding-bottom:10px;">
                                <select name="tamanho" id="combo_tamanho" onChange="recalcular()" >
                                    <option value='0' rel='0' selected >Selecione</option>
                                    <?=$mostra?>
                                </select>
                                </div>
                                
                                <?php } else { ?>

                                    <div style="display:none;">
                                    <select name="tamanho" id="combo_tamanho" >
                                        <option value='0' rel='0' selected >Selecione</option>
                                    </select>
                                    </div>

                                <?php } ?>

                                <?php

                                    $mostra = "";                                    
                                    foreach ($cores as $key => $value) {

                                        $mostra .= "<option value='".$value['codigo']."' rel='".$value['valor']."' >".$value['titulo']."</option>";

                                    }
                                    
                                if($mostra){

                                ?>
                                <div class="produto_detalhes" >Cor:</div>
                                <div style="padding-bottom:10px;">
                                <select name="cor" id="combo_cor" onChange="recalcular()" >
                                    <option value='0' rel='0' selected >Selecione</option>
                                    <?=$mostra?>
                                </select>
                                </div>

                                <?php } else { ?>

                                    <div style="display:none;">
                                    <select name="cor" id="combo_cor" >
                                        <option value='0' rel='0' selected >Selecione</option>
                                    </select>
                                    </div>

                                <?php } ?>

                                <?php

                                    $mostra = "";                                    
                                    foreach ($variacoes as $key => $value) {

                                        $mostra .= "<option value='".$value['codigo']."' rel='".$value['valor']."' >".$value['titulo']."</option>";

                                    }
                                    
                                if($mostra){

                                ?>
                                <div class="produto_detalhes" >Opções:</div>
                                <div style="padding-bottom:10px;">
                                <select name="variacao" id="combo_variacao" onChange="recalcular()" >
                                    <option value='0' rel='0' selected >Selecione</option>
                                    <?=$mostra?>
                                </select>
                                </div>

                                <?php } else { ?>

                                    <div style="display:none;">
                                    <select name="variacao" id="combo_variacao" >
                                        <option value='0' rel='0' selected >Selecione</option>
                                    </select>
                                    </div>

                                <?php } ?>
                                

                                <div class="produto_detalhes_valor" >
                                    <div class="produtos_detalhes_valortotal">Valor Total</div>
                                    <span id="produto_valor_unitario" >R$ <?=$valor_principal?></span>
                                    <div id="produto_detalhes_parcelas"><?=$parcelamento_pagseguro?></div>
                                    <?php if($data->fretegratis == 1){ echo " <span style='font-size:16px; color:#000;' >(Frete Grátis)</span>"; } ?>
                                    <input type='hidden' id='produto_valor_unitario_inicial' name='produto_valor_unitario_inicial' value='<?=$data->valor?>' >
                                </div>
                                
                                <hr>
                                
                                <div id="div_comprar" ></div>
                                
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">
                            
                            <h2 class="titulo_padrao" style="padding-top: 40px;" >Descrição do <span>Produto</span></h2>
                            <div class="titulo_padrao_linha" ></div>

                            <div><?=$data->descricao?></div>

                        </div>
                        
                    </div>

                </div>                    
                
            </div>
            </div>


        </div>
        </div>

    </section>


<?php include_once('htm_newslatter.php'); ?>

<?php include_once('htm_rodape.php'); ?>

<script src="<?=LAYOUT?>js/jquery.js"></script>
<script src="<?=LAYOUT?>js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>js/jquery.scrollUp.min.js"></script>
<script src="<?=LAYOUT?>js/price-range.js"></script>
<script src="<?=LAYOUT?>js/jquery.prettyPhoto.js"></script>
<script src="<?=LAYOUT?>js/main.js"></script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>

<!-- galeria fotos -->
<script src="<?=$config_dominio?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("a[rel^='prettyPhoto']").prettyPhoto();
     });
</script>

<script>
    
    function recalcular(){
        
        var valor_inicial = parseFloat($('#produto_valor_unitario_inicial').attr('value'));
        
        var tamanho = parseFloat($('#combo_tamanho :selected').attr('rel'));
        var tamanho_codigo = parseFloat($('#combo_tamanho :selected').attr('value'));
        
        var cor = parseFloat($('#combo_cor :selected').attr('rel'));
        var cor_codigo = parseFloat($('#combo_cor :selected').attr('value'));

        var variacao = parseFloat($('#combo_variacao :selected').attr('rel'));
        var variacao_codigo = parseFloat($('#combo_variacao :selected').attr('value'));

        var valor_total = valor_inicial + tamanho + cor + variacao;

        var valor_total_tratado = numeroParaMoeda(valor_total);
        $('#produto_valor_unitario').html("R$ "+valor_total_tratado);

        $.post('<?=DOMINIO?>produtos/detalhes_parcela', {valor: valor_total_tratado},function(data){
            if(data){
                $('#produto_detalhes_parcelas').html(data);
            }
        });

        //atualiza botao comprar conforme estoque
        $.post('<?=DOMINIO?>produtos/detalhes_estoque', {id: <?=$data->id?>, produto: <?=$data->codigo?>, tamanho: tamanho_codigo, cor: cor_codigo, variacao: variacao_codigo},function(data){
            if(data){
                $('#div_comprar').html(data);
            }
        });

    }
    recalcular();

</script>

<?php include_once('htm_facebook_lateral.php'); ?>