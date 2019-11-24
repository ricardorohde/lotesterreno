function modal( endereco ){

    $('#modal_conteudo').html("<div style='text-align:center;'><img src='"+dominio()+"_views/img/loading.gif' style='width:25px;'></div>");
    $('#modal_janela').modal('show');

    $.post(endereco, { variaveis: '' }, function(data){
        if(data){
            $('#modal_conteudo').html(data);
        }
    });

}

$("#menu_responsivo_botao").click(function(){
    $("#menu_responsivo").toggle();
});
$("#menu_responsivo a").click(function(){
    $("#menu_responsivo").toggle();
});

function enviar_cadastro_email(){
	
	$('#modal_conteudo').html("<div style='text-align:center;'><img src='"+dominio()+"_views/img/loading.gif' style='width:25px;'></div>");
    $('#modal_janela').modal('show');
    
    var dados = $('#form_news').serialize();
    var endereco = dominio()+"cadastro/gravar_email";
    
    $.post(endereco, dados, function(data){
        if(data){
            $('#modal_conteudo').html(data);
        }
    });

}