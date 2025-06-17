jQuery(document).ready(function () {
    const slide = document.getElementsByClassName('uiimage-parallax');
    var numslides = slide.length;
    if(slide){
        for (var i = 0; i < numslides; i++) {
            slide[i].addEventListener('mousemove', function (e) {
                // Get dimensions of slide element
                const r = this.getBoundingClientRect()

                // Set x and y values prop values based on center of slide element
                this.style.setProperty('--x', e.clientX - (r.left + Math.floor(r.width / 2)))
                this.style.setProperty('--y', e.clientY - (r.top + Math.floor(r.height / 2)))
            })

            slide[i].addEventListener('mouseleave', function () {
                // Reset x and y prop values when no longer hovering
                this.style.setProperty('--x', 0)
                this.style.setProperty('--y', 0)
            })
        }
    }
})