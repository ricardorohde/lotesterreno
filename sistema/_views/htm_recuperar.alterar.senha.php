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
  <link rel="stylesheet" href="<?=LAYOUT?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?=LAYOUT?>plugins/iCheck/square/blue.css">

</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
     <img src="<?=$_logo_b?>" style="max-height:40px;" >
   </div>
   <!-- /.login-logo -->
   <div class="login-box-body">
    <p class="login-box-msg">Redefina sua senha!</p>

    <form action="<?=DOMINIO?>recuperar/alterar_senha_grv" method="post">      

      <div class="form-group has-feedback">
        <div>
          <input type="text" class="form-control" placeholder="Usuário" name="usuario">
        </div>
        <div style="margin-top: 15px;">
          <input type="password" class="form-control" placeholder="Senha" name="senha1">
        </div>
        <div style="margin-top: 15px;">
          <input type="password" class="form-control" placeholder="Confirme sua Senha" name="senha2">
        </div>
      </div>
      
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Alterar Senha</button>
          <input type="hidden" name="key" value="<?=$key?>">
        </div>
      </div>

    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="<?=LAYOUT?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?=LAYOUT?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?=LAYOUT?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>