/**
 * Created by bilel on 28/01/2017.
 */

class AdminAjax {

    constructor() {
    }


    /**
     * Delete Users AJAX response request
     */
    delete_users() {
        $('.btn-remove-users').on('click', function (e) {
            e.preventDefault();
            let id = $(this).parents('.deleteUsers').data('id');
            let form = $('#form_users_destroy');
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
                                location.href = result.redirectToRouteUsers;
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
                                    message: result.message
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
     * Delete Categorie AJAX response request
     */
    delete_categorie() {
        $('.btn-remove-categorie').on('click', function (e) {
            e.preventDefault();
            let id = $(this).parents('.deleteCategorie').data('id');
            let form = $('#form_categorie_destroy');
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
                                location.href = result.redirectToRouteCategorie;
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
                                    message: result.message
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
                                location.href = result.redirectToRouteActu;
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
                                    message: result.message
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
     * Delete Diary AJAX response request
     */
    delete_diary() {
        $('.btn-remove-diary').on('click', function (e) {
            e.preventDefault();
            let id = $(this).parents('.deleteDiary').data('id');
            let form = $('#form_diary_destroy');
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
                                location.href = result.redirectToRouteDiary;
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
                                    message: result.message
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

}