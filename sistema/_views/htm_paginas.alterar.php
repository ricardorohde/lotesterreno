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

          </ul>

          <div class="tab-content" >

           <div id="dados" class="tab-pane <?php if($aba_selecionada == "dados"){ echo "active"; } ?>" >
             <form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">  						

              <fieldset>
               
                <div class="form-group">
                  <label class="col-md-12" >Titulo</label>
                  <div class="col-md-6">
                   <input name="titulo" type="text" class="form-control" value="<?=$data->titulo?>" >
                 </div>
               </div>
               
               <div class="form-group">
                <label class="col-md-12" >Nome para a url (deve ser único, sem caracteres especiais ou acentos e separados por '-' ex: 'nova-pagina-criada')<br>URL Atual: <span style="font-weight: 500;"><?=$url_atual?></span></label>
                <div class="col-md-12">
                  <input name="url" type="text" class="form-control" value="<?=$data->url?>" >
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-md-12">Conteúdo</label>
                <div class="col-md-12">
                  <textarea class="ckeditor" id="conteudo" name="conteudo" rows="10" ><?=$data->conteudo?></textarea>
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
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script>

</body>
</html>