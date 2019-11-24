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

              </ul>

              <div class="tab-content" >


                <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
                  <form action="<?=$_base['objeto']?>alterar_dados" class="form-horizontal" method="post">  						

                    <fieldset>

                      <div style="text-align: left; font-size: 14px; padding-bottom: 20px; color:#666;">* Campos obrigatórios</div>

                      <div class="row">

                        <div class="col-md-3">

                          <div class="form-group">
                            <label class="col-md-12" >Ref.</label>
                            <div class="col-md-12">
                              <input name="ref" type="text" class="form-control" value="<?php if($data->ref){ echo $data->ref; } else { echo $data->id; } ?>" >
                            </div>
                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                            <label class="col-md-12">Cadastro</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="cadastro" >
                                <option value='' selected="" >Selecione</option>
                                <?php
                                
                                foreach ($lista_cadastro as $key => $value) {

                                  if($data->cadastro == $value['codigo']){
                                    $select = " selected='' ";
                                  } else {
                                    if($cadastro_get == $value['codigo']){
                                      $select = " selected='' ";
                                    } else {
                                      $select = "";
                                    }
                                  }

                                  echo "
                                  <option value='".$value['codigo']."' $select >".$value['nome']."</option>
                                  ";

                                }

                                ?>
                              </select>
                            </div>
                          </div>

                        </div>

                      </div>


                      <div class="row">

                        <div class="col-md-5">

                          <div class="form-group">
                            <label class="col-md-12" >*Titulo</label>
                            <div class="col-md-12">
                              <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                            </div>
                          </div>

                        </div>

                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12">*Status</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="status" >
                                <option value="0" <?php if( ($data->status == '0') OR (!$data->status) ){ echo " selected=''; "; } ?> >Inativo</option>
                                <option value="1" <?php if($data->status == '1'){ echo " selected=''; "; } ?> >Ativo</option>
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group">
                            <label class="col-md-12">Destaque</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="destaque" >
                                <option value="0" <?php if( ($data->destaque == '0') OR (!$data->destaque) ){ echo " selected=''; "; } ?> >Inativo</option>
                                <option value="1" <?php if($data->destaque == '1'){ echo " selected=''; "; } ?> >Ativo</option>
                              </select>
                            </div>
                          </div>

                        </div>

                      </div>

                      <div class="row">

                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12">*Categoria</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="categoria" >
                                <option value="" >Selecione</option>
                                <?php

                                foreach ($categorias as $key => $value) {

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

                        </div>

                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12">*Tipo</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="tipo" >
                                <option value="" >Selecione</option>
                                <?php

                                foreach ($tipos as $key => $value) {

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
                        </div>

                      </div>


                      <div class="row">

                        <div class="col-md-6">      

                          <div class="form-group">
                            <label class="col-md-12">*Cidade</label>
                            <div class="col-md-12">
                              <select class="form-control select2" name="cidade" onChange="abre_bairros(this.value)" >
                                <option value="" >Selecione</option>
                                <?php

                                foreach ($cidades as $key => $value) {

                                  if($value['selected']){
                                    $selected = " selected='' ";
                                  } else {
                                    $selected = "";
                                  }

                                  echo "<option value='".$value['codigo']."' $selected >".$value['cidade']." - ".$value['estado']."</option>";

                                }

                                ?>                        
                              </select>
                            </div>
                          </div>

                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                            <label class="col-md-12">*Bairro</label>
                            <div class="col-md-12" id="div_bairros" >
                              <select class="form-control select2" name="bairro" >
                                <option value="" >Selecione primeiro a cidade</option> 
                              </select>
                            </div>
                          </div>

                        </div>

                      </div>

                      <div class="row">                        
                        <div class="col-md-5">

                          <div class="form-group"> 
                            <label class="col-md-12" >Endereço</label>
                            <div class="col-md-12">
                              <input name="endereco" type="text" class="form-control" value="<?=$data->endereco?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-2">

                          <div class="form-group"> 
                            <label class="col-md-12" >Número</label>
                            <div class="col-md-12">
                              <input name="numero" type="text" class="form-control" value="<?=$data->endereco?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-3">

                          <div class="form-group"> 
                            <label class="col-md-12" >Complemento</label>
                            <div class="col-md-12">
                              <input name="complemento" type="text" class="form-control" value="<?=$data->complemento?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-2">

                          <div class="form-group"> 
                            <label class="col-md-12" >Cep</label>
                            <div class="col-md-12">
                              <input name="cep" type="text" class="form-control" value="<?=$data->cep?>" >
                            </div>
                          </div>

                        </div>
                      </div>

                      <hr>

                      <div class="row">                        
                        <div class="col-md-3">

                          <div class="form-group"> 
                            <label class="col-md-12" >Área útil</label>
                            <div class="col-md-12">
                              <input name="area_util" type="text" class="form-control" value="<?=$data->area_util?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-3">

                          <div class="form-group"> 
                            <label class="col-md-12" >Área total</label>
                            <div class="col-md-12">
                              <input name="area_total" type="text" class="form-control" value="<?=$data->area_total?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-3">

                          <div class="form-group"> 
                            <label class="col-md-12" >Garagem</label>
                            <div class="col-md-12">
                              <input name="garagem" type="text" class="form-control" value="<?=$data->garagem?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-3">

                          <div class="form-group"> 
                            <label class="col-md-12" >Churrasqueira</label>
                            <div class="col-md-12">
                              <input name="churrasqueira" type="text" class="form-control" value="<?=$data->churrasqueira?>" >
                            </div>
                          </div>

                        </div>

                      </div>

                      <div class="row">                        
                        <div class="col-md-4">

                          <div class="form-group"> 
                            <label class="col-md-12" >Quartos</label>
                            <div class="col-md-12">
                              <input name="quartos" type="text" class="form-control" value="<?=$data->quartos?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-4">

                          <div class="form-group"> 
                            <label class="col-md-12" >Súites</label>
                            <div class="col-md-12">
                              <input name="suites" type="text" class="form-control" value="<?=$data->suites?>" >
                            </div>
                          </div>

                        </div>
                        <div class="col-md-4">

                          <div class="form-group"> 
                            <label class="col-md-12" >Banheiros</label>
                            <div class="col-md-12">
                              <input name="banheiros" type="text" class="form-control" value="<?=$data->banheiros?>" >
                            </div>
                          </div>

                        </div> 

                      </div>

                      <div class="row">                        
                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12" >*Valor R$ (0,00 para "Consulte")</label>
                            <div class="col-md-12">
                              <input name="valor" type="text" class="form-control" value="<?=$valor?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                            </div>
                          </div> 

                        </div>
                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12" >*Valor Condomínio R$ (0,00 para "Consulte")</label>
                            <div class="col-md-12">
                              <input name="condominio" type="text" class="form-control" value="<?=$condominio?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                            </div>
                          </div> 

                        </div>
                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="col-md-12" >*Valor Iptu R$ (0,00 para "Consulte")</label>
                            <div class="col-md-12">
                              <input name="iptu" type="text" class="form-control" value="<?=$iptu?>" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" >
                            </div>
                          </div>

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
    <script>function dominio(){ return '<?=DOMINIO?>'; }</script>
    <script type="text/javascript">

      function abre_bairros(cidade){

        $('#div_bairros').html("<div style='text-align:left;'><img src='"+dominio()+"_views/img/loading.gif' style='width:25px;'></div>");

        $.post('<?=DOMINIO?>imoveis/lista_bairros',{ cidade:cidade, selecionado:'<?=$data->bairro_id?>' },function(data){
          if(data){
            $('#div_bairros').html(data);
          }
        });

      }

    </script>
    <script>
      $(document).ready(function() {

        $(".select2").select2();

        $( "#sortable_imagem" ).sortable({
          update: function(event, ui){
            var postData = $(this).sortable('serialize');
            console.log(postData);

            $.post('<?=$_base['objeto']?>ordenar_imagem', {list: postData, codigo: '<?=$data->codigo?>'}, function(o){
              console.log(o);
            }, 'json');
          }
        });

        <?php if($data->cidade_id){ ?>

          abre_bairros('<?=$data->cidade_id?>');

        <?php } ?>

      });

    </script>
  </body>
  </html>