(function( $ ){
    $(document).ready(function(){

        function ajaxLoad(){
            accordionSlider();
        }

        ajaxLoad();

        /*----------------------------------------------------*/
        /*	ACCORDION SLIDER
        /*----------------------------------------------------*/

        function accordionSlider(){

            function accordionOrder(){

                var slides = document.querySelectorAll('.accordion-slider .uiaccordion-slide');

                function slidePosition(){
                    if(($(window).width()) > 1024){
                        for (let i = 1; i < slides.length; i++) {
                            var rightValue = 450 - (150 * i);
                            slides[i].style.right = `${rightValue}px`;
                        }
                    }

                    if ($(window).width() < 1200 && $(window).width() > 640) {
                        for (let i = 1; i < slides.length; i++) {
                            var rightValue = 300 - (100 * i);
                            slides[i].style.right = `${rightValue}px`;
                        }
                    }

                    if(($(window).width()) < 640){
                        for (let i = 1; i < slides.length; i++) {
                            var rightValue = 100 - (50 * i);
                            slides[i].style.right = `${rightValue}px`;
                        }
                    }

                }
                slidePosition();
                $(window).on('resize', function() {
                    slidePosition();
                });

            }
            if($('.accordion-slider .uiaccordion-slide:first-child .video-wrapper').length){
                $('.accordion-slider').find('video').get(0).pause();
                var video = $('.accordion-slider .uiaccordion-slide:first-child .video-wrapper').find('video').get(0);
                if (video) {
                    video.play();
                }
            }

            accordionOrder();

            gsap.set($('.accordion-slider .uiaccordion-slide:not(.accordion-slider .uiaccordion-slide:first)').find('.slider-caption h2, .slider-caption .category, .slider-caption .uiaccordion-slider-content, .slider-caption .templaza-btn'), { autoAlpha:0 })

            $('.accordion-slider .uiaccordion-slide').on('click', function(){
                gsap.set($(this).find('a'), { 'display':'inline-block'})
                gsap.set($('.accordion-slider .uiaccordion-slide:not(.accordion-slider .uiaccordion-slide:first)').find('.slider-caption h2, .slider-caption .category, .slider-caption .uiaccordion-slider-content, .slider-caption .templaza-btn'), { autoAlpha:0 })

                gsap.set($('.accordion-slider .uiaccordion-slide'), { 'pointer-events': 'none' })

                if($('.video-wrapper').length){
                    $('.accordion-slider').find('video').get(0).pause();
                    var video = $(this).find('video').get(0);
                    if (video) {
                        video.play();
                    }
                }

                gsap.set($(this), {'z-index': '2' })

                gsap.to( $(this).prevAll().find('.category') , {delay:.8, clearProps: 'all'})
                gsap.to( $(this).prevAll().find('h2') , {delay:.8, clearProps: 'all'})
                gsap.to( $(this).prevAll().find('.uiaccordion-slider-content') , {delay:.8, clearProps: 'all'})
                gsap.to( $(this).prevAll().find('.letter, .slider-icon') , {delay:.8, clearProps: 'all'})
                gsap.to( $(this).prevAll().find('.slider-caption .templaza-btn') , {delay:.8, clearProps: 'all'})

                gsap.to($(this).find('.letter, .slider-icon'), { autoAlpha:0 })
                gsap.to($(this).find('.slider-caption .category'), { autoAlpha:1, x:0, delay:.3, duration:.8})
                gsap.to($(this).find('.slider-caption h2'), { autoAlpha:1, x:0, delay:.5, duration:.8})
                gsap.to($(this).find('.uiaccordion-slider-content'), { autoAlpha:1, x:0, delay:.8, duration:.8})
                gsap.to($(this).find('.slider-caption .templaza-btn'), { autoAlpha:1, x:0, delay:1, duration:.5})

                if(($(window).width()) > 1024){
                    gsap.to($(this), {'width': 'calc(100vw - 450px)', left: 0 })
                }
                if ($(window).width() < 1024 && $(window).width() > 580) {
                    gsap.to($(this), {'width': 'calc(100vw - 300px)', left: 0 })
                }
                if(($(window).width()) < 580){
                    gsap.to($(this), {'width': 'calc(100vw - 100px)', left: 0 })
                }

                $(window).on('resize', function() {

                    if(($(window).width()) > 1024){
                        gsap.to($(this), {'width': 'calc(100vw - 450px)', left: 0 })
                    }
                    if ($(window).width() < 1024 && $(window).width() > 580) {
                        gsap.to($(this), {'width': 'calc(100vw - 300px)', left: 0 })
                    }
                    if(($(window).width()) < 580){
                        gsap.to($(this), {'width': 'calc(100vw - 100px)', left: 0 })
                    }
                });

                gsap.set($(this).nextAll().find('a'), { 'display':'none'})
                gsap.set($(this).nextAll().find('.overlay'), { clearProps: 'all'})
                gsap.to($(this).find('.overlay'), {autoAlpha:1 })

                if ($(window).width() > 1024) {
                    transportAmount =  150;
                }
                if ($(window).width() < 1024 && $(window).width() > 580) {
                    transportAmount = 100;
                }
                if ($(window).width() < 580) {
                    transportAmount =  50;
                }

                $(window).on('resize', function() {

                    if ($(window).width() > 1024) {
                        transportAmount =  150;
                    }
                    if ($(window).width() < 1024 && $(window).width() > 580) {
                        transportAmount = 100;
                    }
                    if ($(window).width() < 580) {
                        transportAmount =  50;
                    }
                });


                gsap.to($(this).nextAll(), { right: '+=' +  $(this).index() * transportAmount + 'px' });


                gsap.to($('.accordion-slider .uiaccordion-slide'), {delay:.8, clearProps: 'transform'})

                setTimeout(() => {
                    $(this).prevAll().removeAttr('style');
                    $(this).prevAll().appendTo('.accordion-slider');
                    accordionOrder();
                    gsap.set($('.accordion-slider .uiaccordion-slide'), { 'pointer-events': 'all' })
                }, 1000);

            });
        }

    })
})( jQuery );
