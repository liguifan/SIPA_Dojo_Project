function centerLayout(){
    $( ".vCenterAlways" ).each(function( index ) {
        $(this).css('padding-top', ($(this).parent().height() - $(this).height())/2);
    });
}

function beautifyCSS()
{
    $('#container').css('min-height', 0);
    $('#container').css('min-height', ($('body').height() - (35 + $('#navHeader').height() + $('#navFooter').height())));
    
    $('.width-450').css('width', '100%').css('width', '-=450px');
    $('.width-120').css('width', '100%').css('width', '-=120px');
    $('.width-270').css('width', '100%').css('width', '-=270px');
}

$( window ).resize(function() {
    respond.update();
    beautifyCSS();
    centerLayout();
});

$(function() {
    beautifyCSS();
    centerLayout();
});

