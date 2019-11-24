<?php require_once('_system/bloqueia_view.php'); ?>
<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Meu Carrinho - <?=$_base['titulo_pagina']?></title>
	<link rel="shortcut icon" href="<?=$_base['favicon'];?>">

	<meta name="description" content="<?=$_base['descricao']?>" />
	<meta property="og:description" content="<?=$_base['descricao']?>">
	<meta name="author" content="ComprePronto.com.br">
	<meta name="classification" content="Website" />
	<meta name="robots" content="index, follow">
	<meta name="Indentifier-URL" content="<?=DOMINIO?>" />
	
	<link href="<?=LAYOUT?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=LAYOUT?>api/font-awesome-4.6.2/css/font-awesome.min.css" rel="stylesheet">
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
            <div class="col-sm-12">
                <h2 class="titulo_padrao" >Meu <span>Carrinho</span></h2>
                <div class="titulo_padrao_linha" style="padding-bottom:50px;"></div>
            </div>
        </div> 
        

        <div class="row">
            <div class="col-sm-12">

                <div class="table-responsive">
                    <table class="table tabela_boa">
                        
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th></th>
                                <th style='text-align:center;' >Preço</th>
                                <th style='text-align:center; width:50px;' >Quantidade</th>
                                <th style='text-align:center; width:120px;' >Total</th>
                                <th style='width:50px;'></th>
                            </tr>
                        </thead>
                        
                        <?php

                        $n = 0;
                        foreach ($carrinho['lista'] as $key => $value) {

                            echo "
                            <tr>

                            <td colspan='2' >
                            <div class='carrinho_lista_imagem' style='background-image:url(".$value['imagem'].");' ></div>
                            <div class='carrinho_lista_texto' ><div style='padding-left:15px; padding-right:15px;'>".$value['titulo']."</div></div>
                            </td>

                            <td style='text-align:center;' >
                            <div class='carrinho_lista_valor' >R$ ".$value['total_unitario']."</div>
                            </td>

                            <td style='width:200px;' >
                            <form name='altera_quantidade_".$value['id']."' action='".DOMINIO."carrinho/quantidade' method='post' >

                            <div style='margin-top:30px; text-align:center;'>
                            <input class='carrinho_quantidade_input' name='quantidade' value='".$value['quantidade']."' onkeypress='Mascara(this,Integer)' onKeyDown='Mascara(this,Integer)' >
                            <button type='button' class='btn btn-fefault cart botao_quantidade' onClick='submit(\"altera_quantidade_".$value['id']."\")' >Atualizar</button>
                            <input type='hidden' name='id' value='".$value['id']."' >
                            </div>

                            </form>
                            </td>

                            <td style='text-align:center; width:120px;' >
                            <div class='carrinho_lista_valor' >R$ ".$value['total_quantidade']."</div>
                            </td>

                            <td style='width:50px;' >
                            <div class='carrinho_lista_remover' ><a href='".DOMINIO."carrinho/remover/id/".$value['id']."' ><i class='fa fa-times' aria-hidden='true'></i></a></td></div>
                            </td>

                            </tr>
                            ";

                            $n++;
                        }

                        if($n != 0){

                            echo "
                            <tr>
                            <td colspan='4' style='text-align:right; ' >Sub-total</td>
                            <td style='text-align:center;  width:120px; font-weight:bold;' >R$ ".$carrinho['subtotal_tratado']."</td>
                            <td></td>
                            </tr>
                            ";

                        } else {

                            echo "
                            <tr>
                            <td colspan='6' style='text-align:center; padding-top:120px; padding-bottom:120px; font-size:20px;' >Seu carrinho está vazio.</td>
                            </tr>
                            ";

                        }

                        ?>
                    </table>
                </div>

            </div>
        </div>


        <?php if($n != 0){ ?>
            <div class="row">


                <div class="col-sm-5">


                    <div style="padding-top: 10px;">
                        <form name="form_cupom" action="<?=DOMINIO?>carrinho/cupom" method="post" >
                            <div class="input-group">
                                <input type="text" name="cupom" class="form-control" placeholder="Digite aqui seu cupom de desconto" value="<?=$data_pedido->cupom?>" >
                                <span class="input-group-btn">
                                    <button class="btn botao_continuar_comprando" type="button" onClick="form_cupom.submit()">Inserir Cupom</button>
                                </span>
                            </div>
                        </form>
                    </div>


                    <div style="margin-top:30px; margin-bottom:30px;">
                        <?php
                        
                        //Calculo de Frete
                        $fretes = "";
                        
                        foreach ($frete_lista as $key => $value) {

                            if($value['selected']){ $select = "checked"; } else { $select = ""; }
                            
                            $fretes .= "
                            <div style='padding-top:5px; '>
                            <input type='radio' name='frete' id='frete_".$value['id']."' value='".$value['id']."' onChange=\"window.location='".DOMINIO."carrinho/frete/id/".$value['id']."/valor_subtotal/".$carrinho['subtotal']."'\" $select style='cursor:pointer;' > <label for='frete_".$value['id']."' style='font-weight:normal; cursor:pointer;' >".$value['titulo']." R$ ".$value['valor_frete_tratado']."</label>
                            </div>
                            ";

                        }
                        
                        ?>

                        <form name="form_frete" action="<?=DOMINIO?>carrinho/cep" method="post" >
                            <div class="input-group">
                                <input type="text" name="cep" class="form-control" placeholder="Digite seu CEP" value="<?=$data_pedido->cep_destino?>" onkeypress="Mascara(this,ceppp)" onKeyDown="Mascara(this,ceppp)" size="9" maxlength="9" >
                                <span class="input-group-btn">
                                    <button class="btn botao_continuar_comprando" type="button" onClick="form_frete.submit()">Calcular Frete</button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div>
                        <?php

                        if($data_pedido->cep_destino){

                            echo "<div style='font-weight:bold; padding-bottom:5px; padding-top:10px;'>Selecione a forma de entrega:</div>";
                            
                            if($fretes){
                                echo $fretes;
                            } else {
                                echo "Nenhuma forma de entrega está disponível para este cep.";
                            }
                             

                        } else {

                            echo "
                            <div style='font-size:16px; color:red' >Digite seu cep para concluir o pedido.</div>
                            ";

                        }

                        ?>
                    </div>
                    
                    
                </div>


                <div class="col-sm-7">


                    <div class="table-responsive" style="padding-top:5px;" >
                        <table class="table tabela_boa">

                            <tr>
                                <td style='text-align:right; border-top:0px;' >Descontos do Cupom (Mínimo de Compra <?=$minimo_compra?>)</td>
                                <td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_desconto_cupom_tratado?></td>
                                <td style='width:50px; border-top:0px;' ></td>
                            </tr>
                            
                            <tr>
                                <td style='text-align:right; border-top:0px;' >Descontos da Forma de Pagamento</td>
                                <td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_desconto_forma_pag_tratado?></td>
                                <td style='width:50px; border-top:0px;' ></td>
                            </tr>
                            
                            <tr>
                                <td style='text-align:right; border-top:0px;' >Total de Frete</td>
                                <td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_frete_tratado?></td>
                                <td style='width:50px; border-top:0px;' ></td>
                            </tr>
                            
                            <tr>
                                <td style='text-align:right; border-top:0px;' >Total do Pedido</td>
                                <td style='text-align:center; width:120px; font-weight:bold; border-top:0px;' >R$ <?=$valor_total_pedido_tratado?></td>
                                <td style='width:50px; border-top:0px;' ></td>
                            </tr>
                            
                        </table>
                    </div>


                    <div>

                        <div style='font-weight:bold; text-align:right; padding-top:15px; padding-bottom:5px;'>Selecione o meio de pagamento:</div>

                        <?php

                        foreach ($pagamento_lista as $key => $value) {

                            if($value['selected']){ $select = "checked"; } else { $select = ""; }

                            echo "
                            <div style='padding-top:5px; text-align:right; '>
                            <label for='pagamento_".$value['id']."' style='font-weight:normal; cursor:pointer;' >".$value['titulo']."</label>
                            <input type='radio' name='pagamento' id='pagamento_".$value['id']."' value='".$value['id']."' onChange=\"window.location='".DOMINIO."carrinho/forma_pagamento/id/".$value['id']."'\" $select style='cursor:pointer;' >
                            </div>
                            ";

                        }

                        ?>

                    </div>

                </div>


            </div>

            <div class="row">                
                <div class="col-sm-12">
                    <div style="width: 100%; margin-top:40px; border-top:1px solid #dddddd;"></div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-6">
                    <div class="ajuste_botoes_carrinho_e" >

                        <button type='button' class='btn btn-fefault cart botao_continuar_comprando' onClick="window.location='<?=DOMINIO?>produtos';" >Continuar Comprando</button>
                        
                    </div>
                </div>
                
                <div class="col-sm-6">

                    <div class="ajuste_botoes_carrinho_d" >

                        <form id="comprar" action="https://pagseguro.uol.com.br/checkout/v2/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">
                            <input type="hidden" name="code" id="code" value="" />
                        </form>
                        
                        <button type='button' class='btn btn-fefault cart botao_finalizar' onclick='finaliza_pedido();' >Finalizar Pedido</button> 
                        
                    </div>

                    <?php if($carrinho['restricoes'] == 1){ ?>
                        
                    <div style="font-size:15px; text-align: right; padding-top: 30px;  ">
                        <strong>ATENÇÃO:</strong> Alguns produtos do seu carrinho são destinados a PROFISSIONAIS e ESTABELECIMENTOS DE SAÚDE, sendo necessário enviar por e-mail uma cópia do Alvará Sanitário e Registro do Responsável Técnico Profissional. Após o cadastro inicial não há necessidade de enviar a documentação novamente.
                    </div>
                    
                    <?php } ?>

                </div>

            </div>

        <?php } ?>

        <div class="row">                
            <div class="col-sm-12">
                <div style="width: 100%; padding-top:60px;"></div>
            </div>
        </div>

    </div> 

</section>

<?php include_once('htm_rodape.php'); ?>

<script src="<?=LAYOUT?>js/jquery.js"></script>
<script src="<?=LAYOUT?>js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>js/jquery.scrollUp.min.js"></script>
<script src="<?=LAYOUT?>js/price-range.js"></script>
<script src="<?=LAYOUT?>js/jquery.prettyPhoto.js"></script>
<script src="<?=LAYOUT?>js/main.js"></script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>

<?php include_once('htm_facebook_lateral.php'); ?>

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>

<script>
    function finaliza_pedido(){

        $('#modal_janela').modal('show');
        $('#modal_conteudo').html("<div style='text-align:center;'><img src='"+dominio()+"_views/img/loading.gif' style='width:25px;'></div>");
        
        $.post('<?=DOMINIO?>carrinho/fechar_pedido','',function(data){
            // testes
        $('#modal_conteudo').html("<div class='carrinho_erro'>"+data+"</div>");
            
            var retorno = JSON.parse(data);
            if(retorno['processo'] == 'ok'){

                // pagseguro
                if(retorno['processo_pg'] == 'pagseguro'){
                    $('#modal_janela').modal('toggle');
                    $('#code').val(retorno['code'][0]);
                    $('#comprar').submit();
                }
                
                // deposito
                if(retorno['processo_pg'] == 'deposito'){
                    window.location="<?=DOMINIO?>meuspedidos/detalhes/codigo/<?=$data_pedido->codigo?>/altera_sessao/true";
                }
                
                // gerencianet
                if(retorno['processo_pg'] == 'gerencianet'){
                    $('#modal_conteudo').html("<div class='carrinho_erro' style='padding-bototm:50px;'><a href='"+retorno['endereco']+"' target='_blank' style='color:#000' ><img src='<?=LAYOUT?>img/logo-boleto.png' style='width:150px;'><br><br>Clique aqui para imprimir seu boleto</a></div>");
                }
                
                // mercadopago
                if(retorno['processo_pg'] == 'mercadopago'){
                    $('#modal_conteudo').html("<div class='carrinho_erro' style='padding-bototm:50px;'><a href='"+retorno['endereco']+"' target='_blank' style='color:#000' >Acesse sua conta para concluir o pagamento<br><br><img src='<?=LAYOUT?>img/logo-mercadopago.png' style='width:150px;'><br><br>Clique aqui para continuar</a></div>");
                }
                
                // paypal
                if(retorno['processo_pg'] == 'paypal'){
                    $('#modal_conteudo').html("<div class='carrinho_erro' style='padding-bototm:50px;'><a href='"+retorno['endereco']+"' target='_blank' style='color:#000' >Acesse sua conta para concluir o pagamento<br><br><img src='<?=LAYOUT?>img/paypal.png' style='width:150px;'><br><br>Clique aqui para continuar</a></div>");
                }
                
            } else {
                if(retorno['erro'] == 2){
                    window.location='<?=DOMINIO?>autenticacao';
                } else {
                    $('#modal_conteudo').html("<div class='carrinho_erro'>"+retorno['erro_msg']+"</div>");
                }
            }
            
        })
    }
</script>