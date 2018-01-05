/**
 * Created by bilel on 28/01/2017.
 */

class Ajax {

    constructor() {
    }

    /**
     * Return City From Code Postal in the page view Profil
     * optimize a long table
     * return response json AJAX
     */
    returnsCityFromCp() {
        $('.cp').keyup(function () {
            if ($(this).val().length === 5) {
                // On récupére l'url à travers un champ hidden du formulaire
                let urlVille = $('.url_ville').val();
                // On traite l'url afin de ne garder que l'url sans le paramètre (cp)
                let traitementUrlVille = urlVille.substr(0, urlVille.length - 5);
                $.ajax({
                    type: 'GET',
                    url: traitementUrlVille + $(this).val(),
                    beforeSend: function () {
                        // Loading animate font
                        if ($('.loading').length == 0) {
                            $('form .ville').parent().append(
                                '<div class="loading"><i class="fa fa-spinner fa-spin"></i></div>'
                            );
                        }
                    },
                    success: function (data) {
                        $('.ville').val(data.ville);
                        $('.loading').remove();
                    }, error(){
                        swal(
                            'Whoooops...',
                            'Nous avons rencontré une erreur !',
                            'error'
                        );
                    }
                });
            } else {
                $('.ville').val('');
            }
        });
    }

    /**
     * Delete user AJAX response request
     */
    delete_users() {
        $('.btn-remove-user').on('click', function (e) {
            e.preventDefault();
            let id = $(this).parents('.deleteUser').data('id');
            let form = $('#form_user_destroy');
            let url = form.attr('action');
            let data = form.serialize();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((res) => {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (result) {
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

                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }, error: function () {
                            swal(
                                'Whoooops...',
                                'Nous avons rencontré une erreur !',
                                'error'
                            );
                        }
                    })
                } else {
                    swal(
                        'Ok',
                        'Faite attention à ce que vous faite !',
                        'info'
                    );
                }
            })
        });
    }

    /**
     * listen in checkbox in change status actualite
     */
    changeStatusActu(){
        $('.changeActuStatus').change(function () {
            console.log($('.changeActuStatus'));
            // On récupére l'url à travers un champ hidden du formulaire
            let urlActuAjax = $('.url_actu_show').val();
            console.log(urlActuAjax);

            $.ajax({
                type: 'POST',
                url: urlActuAjax,
                success: function (data) {
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
                            message: data.message,
                        })
                    );
                }, error(){
                    swal(
                        'Whoooops...',
                        'Nous avons rencontré une erreur !',
                        'error'
                    );
                }
            });

        });
    }

    /**
     * Delete Actu AJAX response request
     */
    delete_actu() {
        $('.btn-remove-actu').on('click', function (e) {
            e.preventDefault();
            let id = $(this).parents('.deleteActu').data('id');
            let form = $('#form_actu_destroy');
            let url = form.attr('action');
            let data = form.serialize();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((res) => {
                if (res.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (result) {
                            // Redirection
                            setTimeout(() => {
                                location.href = result.redirectToActu;
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

                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }, error: function () {
                            swal(
                                'Whoooops...',
                                'Nous avons rencontré une erreur !',
                                'error'
                            );
                        }
                    })
                } else {
                    swal(
                        'Ok',
                        'Faite attention à ce que vous faite !',
                        'info'
                    );
                }
            })
        });
    }

    /**
     * Create Categorie
     * Field Langue and Name and createdAt
     */
    createCategorie(){
        $('.btn-hover-green').on('click', function (e) {
            e.preventDefault();
            let form = $('#form_create_categorie');
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (result) {
                    // close modal bootstrap
                    $(".modal .close").click();

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
                            message: result.message
                        })
                    );
                }, error: function () {
                    swal(
                        'Whoooops...',
                        'Nous avons rencontré une erreur !',
                        'error'
                    );
                }
            })
        });
    }

    /**
     * Return append list categorie
     * return response json AJAX
     */
    appendCategorie() {
        $('.list_categorie').on('focus', function(){
            let url = $('.url_list_categorie').val();
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function () {
                    // Loading animate font
                    console.log('LOADING ...');
                    $('.list_categorie option').remove();
                },
                success: function (result) {
                    $('.list_categorie').append('<option value="" selected="selected">Séléctionnez une catégorie</option>');
                    $.each(result.categorie, function (index, value) {
                        $('.list_categorie').append($('<option>', {value: index, text: value}, '</option>'));
                    })
                }, error(){
                    swal(
                        'Whoooops...',
                        'Nous avons rencontré une erreur !',
                        'error'
                    );
                }
            });
        });
    }


}