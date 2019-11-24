<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>

<form action="<?=$_base['objeto']?>novo_grv" class="form-horizontal" method="post" >
  
  <fieldset>
    
    <div class="form-group">
      <label class="col-md-12">Tipo</label>
      <div class="col-md-12">
        <select data-plugin-selectTwo class="form-control populate" name="tipo" onChange="tipo_cadastro(this.value);" >
          <option value="J" >Pessoa Jurídica</option>
          <option value="F" >Pessoa Física</option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label class="col-md-12" >Nome</label>
      <div class="col-md-12">
        <input name="nome" type="text" class="form-control" >
      </div>
    </div>

  </fieldset>

  <button type="submit" class="btn btn-primary">Salvar</button>

</form>