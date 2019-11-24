$('#busca_principal').show();

$(window).load(function() {

    $('#filtros').show();

    /////////////////////////////////////////////////////////////////////
        //busca detalhada valor
        var slider = new Slider('#alugar_busca_principal_valor', {
            tooltip: 'hide'
        });
        $("#alugar_busca_principal_valor").on("slide", function(slideEvt) {

            var resultado = slideEvt.value;

            var valor_min = numeroParaMoeda(resultado[0]);
            var valor_max = numeroParaMoeda(resultado[1]);

            if(valor_max == '15.000,00'){
                valor_max = 'MÁXIMO';
            } else {             
                valor_max = 'R$ '+valor_max;
            }

            if(valor_min == '0,00'){
                valor_min = 'MÍNIMO';
            } else {             
                valor_min = 'R$ '+valor_min;
            }

            $("#alugar_valor_min").val(valor_min);
            $("#alugar_valor_max").val(valor_max);

        });
        var slider = new Slider('#comprar_busca_principal_valor', {
            tooltip: 'hide'
        });
        $("#comprar_busca_principal_valor").on("slide", function(slideEvt) {

            var resultado = slideEvt.value;

            var valor_min = numeroParaMoeda(resultado[0]);
            var valor_max = numeroParaMoeda(resultado[1]);

            if(valor_max == '1.500.000,00'){
                valor_max = 'MÁXIMO';
            } else {
                valor_max = 'R$ '+valor_max;
            }

            if(valor_min == '0,00'){
                valor_min = 'MÍNIMO';
            } else {             
                valor_min = 'R$ '+valor_min;
            }

            $("#comprar_valor_min").val(valor_min);
            $("#comprar_valor_max").val(valor_max);

        });


             /////////////////////////////////////////////////////////////////////
            //filtros valor
            var slider = new Slider('#alugar_busca_principal_valor_filtro', {
                tooltip: 'hide'
            });
            $("#alugar_busca_principal_valor_filtro").on("slide", function(slideEvt) {

                var resultado = slideEvt.value;
                
                var valor_min = numeroParaMoeda(resultado[0]);
                var valor_max = numeroParaMoeda(resultado[1]);

                if(valor_max == '15.000,00'){
                    valor_max = 'MÁXIMO';
                } else {             
                    valor_max = 'R$ '+valor_max;
                }

                if(valor_min == '0,00'){
                    valor_min = 'MÍNIMO';
                } else {             
                    valor_min = 'R$ '+valor_min;
                }

                $("#alugar_valor_min_filtro").val(valor_min);
                $("#alugar_valor_max_filtro").val(valor_max);

            });
            var slider = new Slider('#comprar_busca_principal_valor_filtro', {
                tooltip: 'hide'
            });
            $("#comprar_busca_principal_valor_filtro").on("slide", function(slideEvt) {

                var resultado = slideEvt.value;
                
                var valor_min = numeroParaMoeda(resultado[0]);
                var valor_max = numeroParaMoeda(resultado[1]);

                if(valor_max == '1.500.000,00'){
                    valor_max = 'MÁXIMO';
                } else {
                    valor_max = 'R$ '+valor_max;
                }

                if(valor_min == '0,00'){
                    valor_min = 'MÍNIMO';
                } else {             
                    valor_min = 'R$ '+valor_min;
                }

                $("#comprar_valor_min_filtro").val(valor_min);
                $("#comprar_valor_max_filtro").val(valor_max);

            });

            //////////////////////////////////////////////////////////////////
            //voltar para o topo
            $(function () {
                $.scrollUp({
                    scrollName: 'scrollUp', // Element ID
                    scrollDistance: 300, // Distance from top/bottom before showing element (px)
                    scrollFrom: 'top', // 'top' or 'bottom'
                    scrollSpeed: 300, // Speed back to top (ms)
                    easingType: 'linear', // Scroll to top easing (see http://easings.net/)
                    animation: 'fade', // Fade, slide, none
                    animationSpeed: 200, // Animation in speed (ms)
                    scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
                            //scrollTarget: false, // Set a custom target element for scrolling to the top
                    scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
                    scrollTitle: false, // Set a custom <a> title if required.
                    scrollImg: false, // Set true to use image
                    activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
                    zIndex: 2147483647 // Z-Index for the overlay
                });
            });

            //////////////////////////////////////////////////////////////////
            //slides
            var url = dominio()+'slides';
            $.post(url, function (html) {
                if(html){
                    $('#slideshow').html(html);
                    setInterval( "slideSwitch()", 10000 );
                }
            });

            numero_imoveis();
            calcula_favoritos();            

        });