jQuery(document).ready(function($) {

    var $slideshow = $('.uigrid-slideshow');
    var delayTimer;

    if($slideshow.length) {

        var $items = $slideshow.find('.uigrid-slideshow-item');

        var firstBg = $items.first().attr('data-bg');
        $slideshow.css({
            'background-image': 'url(' + firstBg + ')'
        });

        $items.on('mouseenter', function(){
            var bg = $(this).attr('data-bg');

            clearTimeout(delayTimer);

            delayTimer = setTimeout(function(){
                $slideshow.css('background-image', 'url(' + bg + ')');
            }, 100);
        });
    }
});