/**
 * Created by kenzo on 25/03/2015.
 */
$(document).ready(function(){
    $("#btnMessages").click(function(){
        console.log("ok");
        var target = $("#divMessages");
        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
});