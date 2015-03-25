/**
 * Created by kenzo on 25/03/2015.
 */
$(document).ready(function(){
    $(".btnOuvrir").click(function(){
        var target = $("#response");
        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
});