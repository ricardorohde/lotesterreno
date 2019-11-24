$(document).ready(function(){


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
        
        
        /////////////////////////////////////////////////////////////////////
        //imagens detalhes
        var owl_detalhes = $('.detalhes_imagens');
        owl_detalhes.owlCarousel({
                autoplay: false,
                nav: true,
                navText:["", ""],
                dots: false,
                margin: 0,
                loop: false,
                URLhashListener:true,
                startPosition: 'URLHash',
                responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }        
        }
        });
        var owl_detalhes_min = $('.detalhes_imagens_miniaturas');
        owl_detalhes_min.owlCarousel({
                autoplay: false,
                nav: true,
                navText:["", ""],
                dots: false,
                margin: 5,
                loop: false,
                URLhashListener: true,
                autoplayHoverPause: true,
                startPosition: 'URLHash',
                responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 6
                },
                1000: {
                    items: 6
                }
        }
        });
        var owl = $('.similares');
                owl.owlCarousel({
                    autoplay: true,
                    autoplayTimeout: 7000,
                    nav: false,
                    navText:["", ""],
                    dots: true,
                    margin: 50,
                    loop: true,
                    responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 3
                    }
                }
        });

        calcula_favoritos();
        
});