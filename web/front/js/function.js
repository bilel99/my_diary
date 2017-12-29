/**
 * Created by bilel on 14/12/2017.
 */

/*********************************************************
 *********************************************************
 *           Send Class Ajax And Call Method
 * *******************************************************
 ********************************************************/
$(document).ready(function(){
    let ajax = new Ajax();
    ajax.returnsCityFromCp();
    ajax.delete_users();
});

/*********************************************************
 *********************************************************
 *           Function Js / jQuery For Browser
 * *******************************************************
 ********************************************************/
$(document).ready(function() {
    // configure the bootstrap datepicker
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});



function juizScrollTo(element){
    $(element).click(function(){
        var goscroll = false;
        var the_hash = $(this).attr("href");
        var regex = new RegExp("\#(.*)","gi");
        var the_element = '';

        if(the_hash.match("\#(.+)")) {
            the_hash = the_hash.replace(regex,"$1");

            if($("#"+the_hash).length>0) {
                the_element = "#" + the_hash;
                goscroll = true;
            }
            else if($("a[name=" + the_hash + "]").length>0) {
                the_element = "a[name=" + the_hash + "]";
                goscroll = true;
            }

            if(goscroll) {
                $('html, body').animate({
                    scrollTop:$(the_element).offset().top
                }, 'slow');
                return false;
            }
        }
    });
};
juizScrollTo('a[href^="#"]');

// return top page
var amountScrolled = 300;

$(window).scroll(function() {
    if ($(window).scrollTop() > amountScrolled ) {
        $('a.sf-back-to-top').fadeIn('slow');
    } else {
        $('a.sf-back-to-top').fadeOut('slow');
    }
});

$('a.sf-back-to-top').click(function() {
    $('html, body').animate({
        scrollTop: 0
    }, 700);
    return false;
});