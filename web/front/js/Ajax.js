/**
 * Created by bilel on 28/01/2017.
 */

class Ajax {

    constructor(){
    }

    /**
     * Delete user AJAX response request
     */
    delete_users(){
        $('.btn-remove-user').on('click', function(e){
            e.preventDefault();

            let id = $(this).parents('.deleteUser').data('id');
            let form = $('#form_user_destroy');
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
            success: function(result){
                // Redirection
                setTimeout(() => {
                    location.href = result.redirectToRouteLogin;
                }, 1500);
                // Affichage du message
                    $('.message').append(
                        iziToast.success({
                            position: 'bottomRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                            progressBarColor: '',
                            backgroundColor: '',
                            messageSize: '',
                            messageColor: '',
                            icon: '',
                            image: '',
                            imageWidth: 50,
                            balloon: true,
                            drag: true,
                            progressBar: true,
                            timeout: 5000,
                            title: 'Bravo',
                            message: result.message,
                        })
                    );
                }, error: function(){
                    swal(
                        'Whoooops...',
                        'Nous avons rencontré une erreur !',
                        'error'
                    );
                }
            })
        });
    }

}