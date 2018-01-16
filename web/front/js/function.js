/**
 * Created by bilel on 14/12/2017.
 */

/*********************************************************
 *********************************************************
 *           Send Class Ajax And Call Method
 * *******************************************************
 ********************************************************/
$(document).ready(function(){
    // FRONT
    let ajax = new Ajax();
    ajax.returnsCityFromCp();
    ajax.delete_users();
    ajax.changeStatusActu();
    ajax.delete_actu();
    ajax.createCategorie();
    ajax.appendCategorie();
    ajax.delete_diary();

    // ADMIN
    let adminAjax = new AdminAjax();
    adminAjax.delete_users();
    adminAjax.delete_categorie();
    adminAjax.delete_actu();
    adminAjax.delete_diary();
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

    // Pré-remplir un champ texte à partir d'un autre champ
    // Detect changement type file
    $('.file').change(function () {
        // Recuperer uniquement le nom de l'image sans le chemin
        var file = $('.file').val().split('\\').pop();
        // Ajouter le nom de l'image à l'autre champ
        $('.namefile').val(file);
    });

    // fadeOut/fadeIn datefin actu
    $('input[name=actif_date_fin]').change(function(){
        if($('input[name=actif_date_fin]').is(':checked')){
            $('.bloc_date_fin').fadeIn();
        } else {
            $('.bloc_date_fin').fadeOut();
        }
    });

});


/**
 * Return top page float btn
 * @param element
 */
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
// return top page float btn
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

/* Table Row Admin */
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
/* End Table Row Admin */