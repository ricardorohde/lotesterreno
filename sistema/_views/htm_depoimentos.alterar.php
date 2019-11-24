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
           
           

           
          <section class="panel">
            <form action="<?=$_base['objeto']?>alterar_grv" class="form-horizontal" method="post">
              
              <div class="panel-body">

                <fieldset>
                 
                  <div class="form-group">
                    <label class="col-md-12" >Nome</label>
                    <div class="col-md-6">
                     <input name="nome" type="text" class="form-control" value="<?=$data->nome?>" >
                   </div>
                 </div>

                 <div class="form-group">
                  <label class="col-md-12" >E-mail</label>
                  <div class="col-md-6">
                   <input name="email" type="text" class="form-control" value="<?=$data->email?>" >
                 </div>
               </div>

               <div class="form-group">
                <label class="col-md-12" >Cidade</label>
                <div class="col-md-6">
                  <input name="cidade" type="text" class="form-control" value="<?=$data->cidade?>" >
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-12">Depoimento</label>
                <div class="col-md-7">
                  <textarea class="form-control" name="conteudo" rows="6" ><?=$data->conteudo?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-12">Status</label>
                <div class="col-md-6">
                  <select name="bloqueio" class="form-control select2" style="width: 100%;" >
                    <option value='1' <?php if($data->bloqueio == 1){ echo "selected=''"; } ?> >Bloqueado</option>
                    <option value='2' <?php if($data->bloqueio == 2){ echo "selected=''"; } ?> >Visível</option>
                  </select>
                </div>
              </div>
              
            </fieldset>

            <div>
              <button type="submit" class="btn btn-primary">Salvar</button>
              <input type="hidden" name="id" value="<?=$data->id?>">
              <button type="button" class="btn btn-default" onClick="window.location='<?=$_base['objeto']?>';" >Voltar</button>
            </div>

          </div>
        </form>
      </section>

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
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script src="<?=LAYOUT?>dist/js/app.min.js"></script>
<script src="<?=LAYOUT?>dist/js/demo.js"></script>
<script>
  $(function(){

    $(".select2").select2();

  //Date picker
  $('.datepicker').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy'
  });

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false,
    showMeridian: false
  });

  CKEDITOR.replace('editor'); 

});
</script>
<script>function dominio(){ return '<?=DOMINIO?>'; }</script>
<script src="<?=LAYOUT?>js/funcoes.js"></script>

</body>
</html>