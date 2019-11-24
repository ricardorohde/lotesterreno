<?php if(!isset($_base['libera_views'])){ header("HTTP/1.0 404 Not Found"); exit; } ?>
<div id="busca_principal" >

  <div class="slogan" ><?=$_base['slogan']?></div>

  <div class="busca_principal_quadro" >

    <ul class="nav nav-tabs">
      <li class="active" >
        <a href="#normal" data-toggle="tab">Busca Rápida</a>
      </li>                
      <li>
        <a href="#refencia" data-toggle="tab">Busca por Código</a>
      </li>
      <li>
        <a href="#detalhada" data-toggle="tab">Busca Detalhada</a>
      </li>
    </ul>

    <div class="tab-content" >

      <div id="normal" class="tab-pane active" >
        <form name="form_busca_principal" id="form_busca_principal" action="<?=DOMINIO?>busca" method="post" >

          <div class="busca_principal_campo_txt">Você precisa alugar ou comprar?</div>

          <div style="text-align:left;">

            <div class="busca_principal_campo_div" >
              <select class="selectpicker" name="categoria" id="categoria"  onChange="numero_imoveis();" > 
                <option value='categoria' <?php if($url_categoria == 'categoria'){ echo "selected=''"; } ?> >Categoria</option>
                <option value='alugar' <?php if($url_categoria == 'alugar'){ echo "selected=''"; } ?> >Alugar</option>
                <option value='comprar' <?php if($url_categoria == 'comprar'){ echo "selected=''"; } ?> >Comprar</option>
              </select>
            </div>

            <div class="busca_principal_campo_div" >
              <select class="selectpicker"  data-live-search="true"  name="tipo" id="tipo" onChange="numero_imoveis();" >

                <option value='' <?php if( ($url_tipo == 'tipo') OR (!$url_tipo) ){ echo "selected"; } ?> >Tipo</option>

                <?php
                foreach ($tipos as $key => $value) {

                  if($value['codigo'] == $url_tipo){ $selected = "selected"; } else { $selected = ""; }

                  echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";

                }

                ?>
              </select>
            </div>

            <div class="busca_principal_campo_div" >
              <select class="selectpicker" data-live-search="true" name="cidade" id="cidade_principal" title="Digite ou selecione a cidade" onChange="carrega_bairros_principal(this.value);" >

                <option value='' <?php if($url_cidade == 'cidade'){ echo "selected"; } ?> >Todas</option>

                <?php

                foreach ($cidades as $key => $value) {

                  if(!$url_cidade){
                    if($value['cidade'] == CIDADE){ $selected = "selected"; } else { $selected = ""; }
                  } else {
                    if($value['cidade'] == $url_cidade){ $selected = "selected"; } else { $selected = ""; }
                  }

                  echo "<option value='".$value['cidade']."' $selected >".$value['cidade']." - ".$value['estado']."</option>";

                }

                ?>
              </select>
            </div>

            <div class="busca_principal_campo_div" >
              <div id="bairros_lista_principal" >


              </div>
            </div>

            <div class="busca_principal_campo_div" >
              <span class="input-group-btn" >
                <button class="btn btn-default botaozao" type="button" onClick="form_busca_principal.submit();" > <i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
              </span>
            </div>

            <div style="clear:both;"></div>

          </div>

        </form>
      </div>


      <div id="refencia" class="tab-pane" >
        <form name="form_busca_referencia" id="form_busca_referencia" action="<?=DOMINIO?>busca" method="post" >

          <div class="busca_principal_campo_div2"  >
            <input name="referencia" id="campo_ref" class="form-control form_referencia" placeholder="Digite o código do imóvel" > 
          </div>

          <div class="busca_principal_campo_div3" >
            <span class="input-group-btn" >
              <button class="btn btn-default botaozao" type="button" onClick="form_busca_referencia.submit();" > <i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
            </span>
          </div>

          <div style="clear:both;" ></div> 

        </form>
      </div>


      <div id="detalhada" class="tab-pane" >
        <form name="form_detalhada" id="form_detalhada" action="<?=DOMINIO?>busca/filtrar" method="post" >


          <div class="row">

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Alugar ou Comprar?</div>
                <div>
                  <select class="selectpicker" name="categoria" id="categoria"  onChange="troca_faixa_preco(this.value);" >
                    <option value='alugar' <?php if($url_categoria == 'alugar'){ echo "selected"; } ?> >Alugar</option>
                    <option value='comprar' <?php if($url_categoria == 'comprar'){ echo "selected"; } ?> >Comprar</option>
                  </select>
                </div>
              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Tipo</div>
                <div>
                  <select class="selectpicker"  data-live-search="true"  name="tipo" id="tipo" >
                    <option value='tipo' <?php if(!$url_tipo == 'tipo'){ echo "selected"; } ?> >Todos</option>
                    <?php

                    foreach ($tipos as $key => $value) {

                      if(!$url_tipo){
                        if($value['titulo'] == 'Apartamento'){ $selected = "selected"; } else { $selected = ""; }
                      } else {
                        if($value['codigo'] == $url_tipo){ $selected = "selected"; } else { $selected = ""; }
                      }

                      echo "<option value='".$value['codigo']."' $selected >".$value['titulo']."</option>";

                    }

                    ?>
                  </select>
                </div>
              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Cidade</div>
                <div>
                  <select class="selectpicker" data-live-search="true" name="cidade" id="cidade" onChange="carrega_bairros(this.value);" >
                    <option value='cidade' <?php if($url_cidade == 'cidade'){ echo "selected"; } ?> >Todas</option>
                    <?php

                    foreach ($cidades as $key => $value) {

                      echo "<option value='".$value['cidade']."' >".$value['cidade']." - ".$value['estado']."</option>";

                    }

                    ?>
                  </select>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class='col-xs-12 col-sm-4 col-md-4'>                            
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Bairro</div>
                <div id="bairros_lista" >
                  <select class="selectpicker" data-live-search="true" name="bairro" id="bairro" >
                    <option value='bairro' selected='' >Todos</option>
                  </select>
                </div>
              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Dormitórios</div>
                <div>
                  <select class="selectpicker" name="dormitorios" id="dormitorios" >
                    <option value='dormitorios' <?php if($url_dormitorios == 'dormitorios'){ echo "selected"; } ?> >Todos</option>
                    <option value='1' <?php if($url_dormitorios == 1){ echo "selected"; } ?> >1</option>
                    <option value='2' <?php if($url_dormitorios == 2){ echo "selected"; } ?> >2</option>
                    <option value='3' <?php if($url_dormitorios == 3){ echo "selected"; } ?> >3</option>
                    <option value='4' <?php if($url_dormitorios >= 4){ echo "selected"; } ?> >4 ou +</option>
                  </select>
                </div>
              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Suítes</div>
                <div>
                  <select class="selectpicker" name="suites" id="suites" >
                    <option value='suites' <?php if($url_suites == 'suites'){ echo "selected"; } ?> >Todos</option>
                    <option value='1' <?php if($url_suites == 1){ echo "selected"; } ?> >1</option>
                    <option value='2' <?php if($url_suites == 2){ echo "selected"; } ?> >2</option>
                    <option value='3' <?php if($url_suites == 3){ echo "selected"; } ?> >3</option>
                    <option value='4' <?php if($url_suites >= 4){ echo "selected"; } ?> >4 ou +</option>
                  </select>
                </div>
              </div>
            </div>

          </div>

          <div class="row">

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >

                <div class="filtros_campo_txt" >Faixa de Preço</div>

                <div id="preco_alugar" <?php if(isset($url_categoria)){ if($url_categoria != 'alugar'){ echo "style='display:none;'"; } } ?> >

                  <div class='faixa_preco_div' ><input name="alugar_valor_min" id="alugar_valor_min" type="text" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="<?php if( ($url_valor_minimo == 'minimo') OR (!isset($url_valor_minimo)) ){ echo "MÍNIMO"; } else { echo "R$ ".$url_valor_minimo_tratado; } ?>" ></div>

                  <div class='faixa_preco_div_txt' >até</div>

                  <div class='faixa_preco_div' ><input name="alugar_valor_max" id="alugar_valor_max" type="text"onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="<?php if( ($url_valor_maximo == 'maximo') OR (!isset($url_valor_maximo)) ){ echo "MÁXIMO"; } else { echo "R$ ".$url_valor_maximo_tratado; } ?>" ></div>

                  <div style="clear:both"></div>

                  <div class="faixa_preco_div2">
                    <input id="alugar_busca_principal_valor" name="alugar_valor" type="text" value="" data-slider-min="0" data-slider-max="15000" data-slider-step="250" data-slider-value="[<?php if( ($url_valor_minimo == 'minimo') OR (!isset($url_valor_minimo)) ){ echo "0"; } else { echo $url_valor_minimo_tratado_busca; } ?>,<?php if( ($url_valor_maximo == 'maximo') OR (!isset($url_valor_maximo)) ){ echo "15000"; } else { echo $url_valor_maximo_tratado_busca; } ?>]" />
                  </div>

                </div>

                <div id="preco_comprar" <?php if($url_categoria != 'comprar'){ echo "style='display:none;'"; } ?> >

                  <div class='faixa_preco_div' ><input name="comprar_valor_min" id="comprar_valor_min" type="text" onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="<?php if( ($url_valor_minimo == 'minimo') OR (!isset($url_valor_minimo)) ){  echo "MÍNIMO"; } else { echo "R$ ".$url_valor_minimo_tratado; } ?>" ></div>

                  <div class='faixa_preco_div_txt' >até</div>

                  <div class='faixa_preco_div' ><input name="comprar_valor_max" id="comprar_valor_max" type="text"onkeypress="Mascara(this,MaskMonetario)" onKeyDown="Mascara(this,MaskMonetario)" value="<?php if( ($url_valor_maximo == 'maximo') OR (!isset($url_valor_maximo)) ){ echo "MÁXIMO"; } else { echo "R$ ".$url_valor_maximo_tratado; } ?>" ></div>

                  <div style="clear:both"></div>

                  <div class="faixa_preco_div2" >
                    <input id="comprar_busca_principal_valor" name="comprar_valor" type="text" value="" data-slider-min="0" data-slider-max="1500000" data-slider-step="50000" data-slider-value="[<?php if( ($url_valor_minimo == 'minimo') OR (!isset($url_valor_minimo) ) ){ echo "0"; } else { echo $url_valor_minimo_tratado_busca; } ?>,<?php if( ($url_valor_maximo == 'maximo') OR (!isset($url_valor_maximo)) ){ echo "1500000"; } else { echo $url_valor_maximo_tratado_busca; } ?>]" />
                  </div>

                </div>

              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div3" >
                <div class="filtros_campo_txt" >Ordenar Por</div>
                <div>
                  <select class="selectpicker" name="ordem" id="ordem" >
                    <option value='0' <?php if($url_ordem == 0){ echo "selected"; } ?> >Mais Recentes</option>
                    <option value='1' <?php if($url_ordem == 1){ echo "selected"; } ?> >Mais Antigos</option>
                    <option value='2' <?php if($url_ordem == 2){ echo "selected"; } ?> >Maior Valor</option>
                    <option value='3' <?php if($url_ordem == 3){ echo "selected"; } ?> >Menor Valor</option>
                  </select>
                </div>
              </div>
            </div>

            <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class="filtros_div4" >

                <button class="btn btn-default botaozinho" type="button" onClick="form_detalhada.submit();" > <i class="fa fa-search" aria-hidden="true"></i> Buscar </button>

              </div>
            </div>


          </div>

        </form>
      </div>

    </div> 

  </div>

</div>