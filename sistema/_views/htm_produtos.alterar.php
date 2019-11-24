<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title><?=$_titulo?> - <?=TITULO_VIEW?></title>
  <link rel="icon" href="<?=FAVICON?>" type="image/x-icon" />
  
  <link rel="stylesheet" href="<?=LAYOUT?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>font-awesome-4.6.2/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datatables/dataTables.bootstrap.css">   
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.css"/>
  <link rel="stylesheet" href="<?=LAYOUT?>css/css.css">
  
</head>
<body class="hold-transition skin-blue <?php if($_base['menu_fechado'] == 1){ echo "sidebar-collapse"; } ?> sidebar-mini">
  <div class="wrapper">

    <?php require_once('htm_modal.php'); ?>

    <?php require_once('htm_topo.php'); ?>

    <?php require_once('htm_menu.php'); ?>

    <div class="content-wrapper">

     <section class="content-header">
       <h1>
         <?=$_titulo?>
         <small><?=$_subtitulo?></small>
       </h1>
     </section>

     <!-- Main content -->
     <section class="content">
       <div class="row">        	
         <div class="col-xs-12">


           <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">

             <li <?php if($aba_selecionada == "dados"){ echo "class='active'"; } ?> >
              <a href="#dados" data-toggle="tab">Dados</a>
            </li>
            <li <?php if($aba_selecionada == "imagem"){ echo "class='active'"; } ?> onClick="carrega_envio_imagens();" >
              <a href="#imagem" data-toggle="tab">Imagens</a>
            </li>
            <li <?php if($aba_selecionada == "categorias"){ echo "class='active'"; } ?> >
              <a href="#categorias" data-toggle="tab">Categorias</a>
            </li>
            <li <?php if($aba_selecionada == "tamanhos"){ echo "class='active'"; } ?> >
              <a href="#tamanhos" data-toggle="tab">Tamanhos</a>
            </li>
            <li <?php if($aba_selecionada == "cores"){ echo "class='active'"; } ?> >
              <a href="#cores" data-toggle="tab">Cores</a>
            </li>
            <li <?php if($aba_selecionada == "variacoes"){ echo "class='active'"; } ?> >
              <a href="#variacoes" data-toggle="tab">Variações</a>
            </li>
            <li <?php if($aba_selecionada == "frete"){ echo "class='active'"; } ?> >
              <a href="#frete" data-toggle="tab">Frete</a>
            </li>
            <li <?php if($aba_selecionada == "estoque"){ echo "class='active'"; } ?> >
              <a href="#estoque" data-toggle="tab">Estoque</a>
            </li>
            <li <?php if($aba_selecionada == "entrega_auto"){ echo "class='active'"; } ?> >
              <a href="#entrega_auto" data-toggle="tab">Entrega Automática (Produtos Digitais)</a>
            </li>
            
          </ul>
          
          <div class="tab-content" >

           <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
             <form action="<?=$_base['objeto']?>alterar_produto_dados" class="form-horizontal" method="post">  						

              <fieldset>

                <div class="form-group">
                  <label class="col-md-12" >Ref.</label>
                  <div class="col-md-2">
                    <input name="ref" type="text" class="form-control" value="<?=$data->ref?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Marca</label>
                  <div class="col-md-6">
                    <select class="form-control select2" name="marca" >
                      <option value="0" <?php if( ($data->marca == 0) OR (!$data->marca) ){ echo "selected"; } ?> >Indefinido</option>
                      <?php

                      foreach ($marcas as $key => $value) {

                        if($value['selected']){
                          $selected = " selected='' ";
                        } else {
                          $selected = "";
                        }

                        echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";

                      }

                      ?>                        
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >*Titulo</label>
                  <div class="col-md-6">
                    <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12" >De R$ (valor ilustrativo)</label>
                  <div class="col-md-3">
                    <input name="valor_falso" type="text" class="form-control" value="<?=$valor_falso?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-12" >*Por R$ (valor final)</label>
                  <div class="col-md-3">
                    <input name="valor" type="text" class="form-control" value="<?=$valor?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-12">Valor Logado (mostra o valor somente se estiver cadastrado e logado)</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="esconder_valor" >
                      <option value="0" <?php if( $data->esconder_valor == 0 ){ echo "selected"; } ?> >Não</option>
                      <option value="1" <?php if( $data->esconder_valor == 1 ){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Produto Restrito (precisa de documentação para finalizar a compra)</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="msg_restrito" >
                      <option value="0" <?php if( $data->msg_restrito == 0 ){ echo "selected"; } ?> >Não</option>
                      <option value="1" <?php if( $data->msg_restrito == 1 ){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Produto Digital (entrega feita atravez de arquivos pela internet)</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="digital" >
                      <option value="0" <?php if( $data->digital == 0 ){ echo "selected"; } ?> >Não</option>
                      <option value="1" <?php if( $data->digital == 1 ){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Entrega Automática (produtos digitais)</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="digital_entrega" >
                      <option value="0" <?php if( $data->digital_entrega == 0 ){ echo "selected"; } ?> >Não</option>
                      <option value="1" <?php if( $data->digital_entrega == 1 ){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>                

                <div class="form-group">
                  <label class="col-md-12">Aceitar Venda Sem Estoque</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="semestoque" >
                      <option value="0" <?php if( $data->semestoque == 0 ){ echo "selected"; } ?> >Não</option>
                      <option value="1" <?php if( $data->semestoque == 1 ){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Destaque (mostra na pagina inicial)</label>
                  <div class="col-md-3">
                    <select class="form-control select2" name="destaque" >
                      <option value='0' <?php if($data->destaque == 0){ echo "selected"; } ?> >Não</option>
                      <option value='1' <?php if($data->destaque == 1){ echo "selected"; } ?> >Sim</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-12">Ativar/Desativar (mostrar ou esconder da lista)</label>
                  <div class="col-md-3">
                    <select data-plugin-selectTwo class="form-control populate" name="esconder" >
                      <option value='0' <?php if($data->esconder == 0){ echo "selected"; } ?> >Ativo</option>
                      <option value='1' <?php if($data->esconder == 1){ echo "selected"; } ?> >Inativo</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-12">Prévia (utilizado para descrição rapida nos motores de busca)</label>
                  <div class="col-md-12">
                    <textarea name="previa" rows="5" class="form-control" ><?=$data->previa?></textarea>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-12">Descrição</label>
                  <div class="col-md-12">
                    <textarea class="ckeditor" id="descricao" name="descricao" rows="10" ><?=$data->descricao?></textarea>
                  </div>
                </div>
                
              </fieldset>
              
              <div>
                <button type="submit" class="btn btn-primary">Salvar</button>
                <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
                <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
              </div>

            </form>
          </div>



          <div id="imagem" class="tab-pane <?php if($aba_selecionada == "imagem"){ echo "active"; } ?>" >

            <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>upload/codigo/<?=$data->codigo?>', 'Enviar Imagens');" >Carregar Imagens</button>

            <hr>

            <div style="text-align:center;">
              <ul id="sortable_imagem" >
                <?php

                $n = 0;
                foreach ($imagens as $key => $value) {

                  echo "
                  <li id='item_".$value['id']."' >

                  <div class='quadro_img' style='background-image:url(".$value['imagem_p']."); '></div>
                  <div style='padding-top:5px; text-align:center;'>                         
                  <button class='btn btn-default fa fa-times-circle' onClick=\"confirma_apagar('".$_base['objeto']."apagar_imagem/codigo/$data->codigo/id/".$value['id']."');\" title='Remover imagem' ></button>
                  <button class='btn btn-default fa fa-repeat' onClick=\"window.location='".$_base['objeto']."girar_imagem/codigo/$data->codigo/id/".$value['id']."';\" title='Girar imagem' ></button>
                  </div>

                  </li>
                  ";

                  $n++;
                }

                ?>
              </ul>
            </div>

            <?php if($n == 0){ ?>

              <div style="text-align:center; padding-top:100px; padding-bottom:100px;">Nenhuma imagem adicionada!</div>

            <?php } ?>

            <div>
              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
            </div>

          </div> 


          


          <div id="categorias" class="tab-pane <?php if($aba_selecionada == "categorias"){ echo "active"; } ?>" >
            <form action="<?=$_base['objeto']?>alterar_produto_categorias" class="form-horizontal" method="post">   

              <div>
               <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>categorias';" >Alterar Categorias</button>
             </div>

             <hr>

             <div style="font-size:15px; padding-bottom:20px; ">Marque as categorias que se enquadram neste produto.</div>

             <div>
              <?php

              function montaCategoriasView($id_pai, $categorias, $padding){

                foreach ($categorias as $key => $value) {

                  if($value['id_pai'] == $id_pai){

                    if($value['check_prod']){
                      $sel = "checked";
                    } else {
                      $sel = "";
                    }

                    echo '
                    <div style="margin-top:5px; margin-left:'.$padding.'px;" >
                    <div class="categoria_produto">
                    <input type="checkbox" class="marcar" '.$sel.' id="categoria_'.$value['id'].'" name="categoria_'.$value['id'].'"  value="1" >
                    <label for="categoria_'.$value['id'].'">'.$value['titulo'].'</label>
                    </div>
                    </div>
                    ';

                    montaCategoriasView($value['id'], $value['subcategorias'], $padding+20);
                  }
                }
              }
              montaCategoriasview(0, $categorias, 0);

              ?>
            </div>

            <hr>

            <div>
              <button type="submit" class="btn btn-primary">Salvar</button>
              <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
            </div>

          </form>
        </div>





        <div id="tamanhos" class="tab-pane <?php if($aba_selecionada == "tamanhos"){ echo "active"; } ?>" >
          <form action="<?=$_base['objeto']?>alterar_produto_tamanhos" class="form-horizontal" method="post">   

            <div>
             <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>tamanhos';" >Alterar Tamanhos</button>
           </div>

           <hr>

           <div style="font-size:15px; padding-bottom:20px; ">Marque os tamanhos que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>

           <div>
            <table class="table table-bordered table-striped">

              <thead>
                <tr>
                  <th>Sel.</th>
                  <th>Titulo</th>
                  <th>Valor Adicional</th>
                </tr>
              </thead>
              
              <tbody>
                <?php
                
                foreach ($tamanhos as $key => $value) {

                  if($value['check_prod']){
                    $sel = "checked";
                  } else {
                    $sel = "";
                  }

                  echo "
                  <tr id='item_".$value['id']."' >
                  <td style='width:30px;' ><input type='checkbox' class='marcar' name='tamanho_".$value['id']."' value='1' $sel ></td>
                  <td>".$value['titulo']."</td>
                  <td>
                  <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
                  </td>
                  </tr>
                  ";

                }
                
                ?>
              </tbody>

            </table>
          </div>

          <hr>

          <div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
            <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
          </div>

        </form>
      </div>




      <div id="cores" class="tab-pane <?php if($aba_selecionada == "cores"){ echo "active"; } ?>" >
        <form action="<?=$_base['objeto']?>alterar_produto_cores" class="form-horizontal" method="post">   

          <div>
           <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>cores';" >Alterar Cores</button>
         </div>

         <hr>

         <div style="font-size:15px; padding-bottom:20px; ">Marque as cores que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>

         <div>
          <table class="table table-bordered table-striped">

            <thead>
              <tr>
                <th>Sel.</th>
                <th>Titulo</th>
                <th>Valor Adicional</th>
              </tr>
            </thead>

            <tbody>
              <?php

              foreach ($cores as $key => $value) {

                if($value['check_prod']){
                  $sel = "checked";
                } else {
                  $sel = "";
                }

                echo "
                <tr id='item_".$value['id']."' >
                <td style='width:30px;' ><input type='checkbox' class='marcar' name='cor_".$value['id']."' value='1' $sel ></td>
                <td>".$value['titulo']."</td>
                <td>
                <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
                </td>
                </tr>
                ";

              }

              ?>
            </tbody>

          </table>
        </div>

        <hr>

        <div>
          <button type="submit" class="btn btn-primary">Salvar</button>
          <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
          <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
        </div>

      </form>
    </div>




    <div id="variacoes" class="tab-pane <?php if($aba_selecionada == "variacoes"){ echo "active"; } ?>" >
      <form action="<?=$_base['objeto']?>alterar_produto_variacoes" class="form-horizontal" method="post">   

        <div>
         <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>variacoes';" >Alterar Variações</button>
       </div>

       <hr>

       <div style="font-size:15px; padding-bottom:20px; ">Marque as variações que se enquadram neste produto e se necessário coloque o valor adicional no produto.</div>

       <div>
        <table class="table table-bordered table-striped">

          <thead>
            <tr>
              <th>Sel.</th>
              <th>Titulo</th>
              <th>Valor Adicional</th>
            </tr>
          </thead>

          <tbody>
            <?php

            foreach ($variacoes as $key => $value) {

              if($value['check_prod']){
                $sel = "checked";
              } else {
                $sel = "";
              }

              echo "
              <tr id='item_".$value['id']."' >
              <td style='width:30px;' ><input type='checkbox' class='marcar' name='variacao_".$value['id']."' value='1' $sel ></td>
              <td>".$value['titulo']."</td>
              <td>
              <input name='valor_".$value['id']."' type='text' class='form-control' value='".$value['valor']."' onkeypress=\"Mascara(this,MaskMonetario)\" onKeyDown=\"Mascara(this,MaskMonetario)\" >
              </td>
              </tr>
              ";

            }

            ?>
          </tbody>

        </table>
      </div>

      <hr>

      <div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
      </div>

    </form>
  </div>





  <div id="frete" class="tab-pane <?php if($aba_selecionada == "frete"){ echo "active"; } ?>" >
    <form action="<?=$_base['objeto']?>alterar_produto_frete" class="form-horizontal" method="post">

      <fieldset>

        <div class="form-group">
          <label class="col-md-12">Cobrar Frete</label>
          <div class="col-md-3">
            <select data-plugin-selectTwo class="form-control populate" name="fretegratis" >
              <option value='0' <?php if( ($data->fretegratis == 0) OR (!$codigo) ){ echo "selected"; } ?> >Sim</option>
              <option value='1' <?php if($data->fretegratis == 1){ echo "selected"; } ?> >Não</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-12" >*Peso em gramas (1000 para 1kg)</label>
          <div class="col-md-2">
            <input name="peso" type="text" class="form-control" value="<?=$data->peso?>" onkeypress="Mascara(this,Integer)" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-12" >Largura em Centímetros (opcional)</label>
          <div class="col-md-2">
            <input name="largura" type="text" class="form-control" value="<?=$data->largura?>" onkeypress="Mascara(this,Integer)" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-12" >Comprimento em Centímetros (opcional)</label>
          <div class="col-md-2">
            <input name="comprimento" type="text" class="form-control" value="<?=$data->comprimento?>" onkeypress="Mascara(this,Integer)" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-12" >Altura em Centímetros (opcional)</label>
          <div class="col-md-2">
            <input name="altura" type="text" class="form-control" value="<?=$data->altura?>" onkeypress="Mascara(this,Integer)" >
          </div>
        </div>

      </fieldset>

      <hr>

      <div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="hidden" name="codigo" value="<?=$data->codigo?>" >
        <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
      </div>

    </form>
  </div>



  <div id="estoque" class="tab-pane <?php if($aba_selecionada == "estoque"){ echo "active"; } ?>" >

    <div>
     <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>alterar_estoque/produto/<?=$data->codigo?>/retorno/2', 'Alterar Estoque');">Alterar Estoque</button>
   </div>

   <hr>

   <div>
    <table class="table table-bordered table-striped">

      <thead>
        <tr>
          <th>Produto</th>
          <th>Tamanho</th>
          <th>Cor</th>
          <th>Variação</th>
          <th>Quantidade</th>
          <th></th>
        </tr>
      </thead>
      
      <tbody>
        <?php
        
        foreach ($estoque as $key => $value) {
          
          $linklinha = "onClick=\"modal('".$_base['objeto']."alterar_estoque/produto/".$value['produto']."/tamanho/".$value['tamanho']."/cor/".$value['cor']."/variacao/".$value['variacao']."/retorno/2', 'Alterar Estoque');\"style='cursor:pointer;' ";
          
          $extrato = "onClick=\"modal('".$_base['objeto']."extrato_estoque/registro/".$value['registro']."/', 'Extrato');\"style='cursor:pointer;' ";
          
          echo "
          <tr>
          <td $linklinha >".$value['produto_titulo']."</td>
          <td $linklinha >".$value['tamanho_titulo']."</td>
          <td $linklinha >".$value['cor_titulo']."</td>
          <td $linklinha >".$value['variacao_titulo']."</td>
          <td $linklinha >".$value['quantidade']."</td>
          <td $extrato >Extrato</td>
          </tr>
          ";

        }

        ?>
      </tbody>

    </table>
  </div>              

</div>


<div id="entrega_auto" class="tab-pane <?php if($aba_selecionada == "entrega_auto"){ echo "active"; } ?>" >

  <div>
   <button type="button" class="btn btn-primary" onClick="modal('<?=$_base['objeto']?>alterar_entrega_auto/produto/<?=$data->codigo?>/retorno/2', 'Alterar Mensagem de Entrega');">Alterar</button>
 </div>

 <hr>

 <div>
  <table class="table table-bordered table-striped">

    <thead>
      <tr>
        <th>Produto</th>
        <th>Tamanho</th>
        <th>Cor</th>
        <th>Variação</th>
      </tr>
    </thead>

    <tbody>
      <?php

      foreach ($lista_entrega_auto as $key => $value) {

        $linklinha = "onClick=\"modal('".$_base['objeto']."alterar_entrega_auto/produto/".$value['produto']."/tamanho/".$value['tamanho']."/cor/".$value['cor']."/variacao/".$value['variacao']."/retorno/2', 'Alterar Estoque');\"style='cursor:pointer;' ";

        echo "
        <tr>
        <td $linklinha >".$value['produto_titulo']."</td>
        <td $linklinha >".$value['tamanho_titulo']."</td>
        <td $linklinha >".$value['cor_titulo']."</td>
        <td $linklinha >".$value['variacao_titulo']."</td>
        </tr>
        ";

      }

      ?>
    </tbody>

  </table>
</div>              

</div>


</div>

</div>
</div>
<!-- /.row -->
</section>
<!-- /.content -->

</div>
<!-- /.content-wrapper -->
<?php require_once('htm_rodape.php'); ?>

</div>
<!-- ./wrapper -->

<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/select2/select2.full.min.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?=LAYOUT?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?=LAYOUT?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=LAYOUT?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?=LAYOUT?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?=LAYOUT?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?=LAYOUT?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
<script src="<?=LAYOUT?>plugins/fastclick/fastclick.js"></script>
<script src="<?=LAYOUT?>ckeditor412/ckeditor.js"></script>
<script src="<?=LAYOUT?>api/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="<?=LAYOUT?>api/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<script src="<?=LAYOUT?>js/canvas-to-blob.min.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script> 
<script src="<?=LAYOUT?>js/funcoes.js"></script>

<script>
  $(document).ready(function() {

    $(".select2").select2();

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue'
    });

    $( "#sortable_imagem" ).sortable({
      update: function(event, ui){
        var postData = $(this).sortable('serialize');
        console.log(postData);

        $.post('<?=$_base['objeto']?>ordenar_imagem', {list: postData, codigo: '<?=$data->codigo?>'}, function(o){
          console.log(o);
        }, 'json');
      }
    });

  });
</script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>

</body>
</html>