jQuery(document).ready(function(){

    function ajaxLoad(){
        accordionSlider();
    }

    ajaxLoad();

    /*----------------------------------------------------*/
    /*	ACCORDION SLIDER
    /*----------------------------------------------------*/

    function accordionSlider(){

        function accordionOrder(){


            var slides = document.querySelectorAll('.accordion-slider .slide');

            function slidePosition(){
                if((jQuery(window).width()) > 1024){
                    for (let i = 1; i < slides.length; i++) {
                        var rightValue = 450 - (150 * i);
                        slides[i].style.right = `jQuery{rightValue}px`;
                    }
                }

                if (jQuery(window).width() < 1024 && jQuery(window).width() > 580) {
                    for (let i = 1; i < slides.length; i++) {
                        var rightValue = 300 - (100 * i);
                        slides[i].style.right = `jQuery{rightValue}px`;
                    }
                }

                if((jQuery(window).width()) < 580){
                    for (let i = 1; i < slides.length; i++) {
                        var rightValue = 100 - (50 * i);
                        slides[i].style.right = `jQuery{rightValue}px`;
                    }
                }

            }
            slidePosition();
            jQuery(window).on('resize', function() {
                slidePosition();
            });

        }

        accordionOrder();


        gsap.set(jQuery('.accordion-slider .slide:not(.accordion-slider .slide:first)').find('.slider-caption h2, .slider-caption .category'), { autoAlpha:0 })

        jQuery('.accordion-slider .slide').on('click', function(){
            gsap.set(jQuery(this).find('a'), { 'display':'inline-block'})
            gsap.set(jQuery('.accordion-slider .slide:not(.accordion-slider .slide:first)').find('.slider-caption h2, .slider-caption .category'), { autoAlpha:0 })

            gsap.set(jQuery('.accordion-slider .slide'), { 'pointer-events': 'none' })

            jQuery('.accordion-slider').find('video').get(0).pause();
            var video = jQuery(this).find('video').get(0);
            if (video) {
                video.play();
            }

            gsap.set(jQuery(this), {'z-index': '2' })

            gsap.to( jQuery(this).prevAll().find('.category') , {delay:.8, clearProps: 'all'})
            gsap.to( jQuery(this).prevAll().find('h2') , {delay:.8, clearProps: 'all'})
            gsap.to( jQuery(this).prevAll().find('.letter') , {delay:.8, clearProps: 'all'})

            gsap.to(jQuery(this).find('.letter'), { autoAlpha:0 })
            gsap.to(jQuery(this).find('.slider-caption .category'), { autoAlpha:1, x:0, delay:.3, duration:.8})
            gsap.to(jQuery(this).find('.slider-caption h2'), { autoAlpha:1, x:0, delay:.5, duration:.8})

            if((jQuery(window).width()) > 1024){
                gsap.to(jQuery(this), {'width': 'calc(100vw - 450px)', left: 0 })
            }
            if (jQuery(window).width() < 1024 && jQuery(window).width() > 580) {
                gsap.to(jQuery(this), {'width': 'calc(100vw - 300px)', left: 0 })
            }
            if((jQuery(window).width()) < 580){
                gsap.to(jQuery(this), {'width': 'calc(100vw - 100px)', left: 0 })
            }

            jQuery(window).on('resize', function() {

                if((jQuery(window).width()) > 1024){
                    gsap.to(jQuery(this), {'width': 'calc(100vw - 450px)', left: 0 })
                }
                if (jQuery(window).width() < 1024 && jQuery(window).width() > 580) {
                    gsap.to(jQuery(this), {'width': 'calc(100vw - 300px)', left: 0 })
                }
                if((jQuery(window).width()) < 580){
                    gsap.to(jQuery(this), {'width': 'calc(100vw - 100px)', left: 0 })
                }
            });

            gsap.set(jQuery(this).nextAll().find('a'), { 'display':'none'})
            gsap.set(jQuery(this).nextAll().find('.overlay'), { clearProps: 'all'})
            gsap.to(jQuery(this).find('.overlay'), {autoAlpha:0 })

            if (jQuery(window).width() > 1024) {
                transportAmount =  150;
            }
            if (jQuery(window).width() < 1024 && jQuery(window).width() > 580) {
                transportAmount = 100;
            }
            if (jQuery(window).width() < 580) {
                transportAmount =  50;
            }

            jQuery(window).on('resize', function() {

                if (jQuery(window).width() > 1024) {
                    transportAmount =  150;
                }
                if (jQuery(window).width() < 1024 && jQuery(window).width() > 580) {
                    transportAmount = 100;
                }
                if (jQuery(window).width() < 580) {
                    transportAmount =  50;
                }
            });


            gsap.to(jQuery(this).nextAll(), { right: '+=' +  jQuery(this).index() * transportAmount + 'px' });


            gsap.to(jQuery('.accordion-slider .slide'), {delay:.8, clearProps: 'transform'})

            setTimeout(() => {
                jQuery(this).prevAll().removeAttr('style');
                jQuery(this).prevAll().appendTo('.accordion-slider');
                accordionOrder();
                gsap.set(jQuery('.accordion-slider .slide'), { 'pointer-events': 'all' })
            }, 1000);

        });

        var swiper = new Swiper(".client-slider", {
            // Optional parameters
            slidesPerView: 1.7,
            spaceBetween: 0,
            centeredSlides: true,
            speed: 2500,
            autoplay: {
                delay: 0,
            },
            loop: true,
            allowTouchMove: false,
            disableOnInteraction: true,
        });


    }

})