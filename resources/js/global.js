import Swal from 'sweetalert2';

$(function () {

    $("#mobile-menu-toggler").on("click", function () {
        $("nav").slideToggle();
    });

    $(".accordion-title").on("click", function () {
        $(this).siblings(".accordion-content").slideToggle();
    });

    $(".copy-shortened-link").on("click", function () {

        $(".copy-shortened-link.copied").html("COPY");

        $(".copy-shortened-link.copied").removeClass("copied");

        $(this).html("COPIED");

        $(this).addClass("copied");

        const linkToCopy = $(this).attr("data-link");
        
        navigator.clipboard.writeText(linkToCopy);

    });

    $(".shorten-url-form").on("submit", function (e) {

        e.preventDefault();

        const form = $(this);

        $(form).find(".form-validation-error").remove();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/URLs',
            type: 'POST',
            data: $(form).serialize(),
            statusCode: {
                201: function (res) {
                    const data = res;
                    const createdShortURL = res.shortURL;
                    window.location = `/URLs/${createdShortURL}`;
                },
                400: function (res) {
                    const data = JSON.parse(res.responseText);

                    data.errors.forEach(error => {
                        $(`<p class="form-validation-error">${error}</p>`).insertBefore($(form).find('input[type="submit"]'));
                    });
                },
                500: function () {
                    $(`<p class="form-validation-error">Looks like something went wrong. Try again later.</p>`).insertBefore($(form).find('input[type="submit"]'));
                }
            }
        });

    });

    $(".form-login-register").on("submit", function (e) {

        e.preventDefault();

        const form = $(this);

        $(form).find(".form-validation-error").remove();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/login',
            type: 'POST',
            data: $(form).serialize(),
            statusCode: {
                200: function (res) {
                    window.location = "/my-links";
                },
                400: function (res) {
                    const data = JSON.parse(res.responseText);

                    data.errors.forEach(error => {
                        $(`<p class="form-validation-error">${error}</p>`).insertBefore($(form).find('.login-register-buttons'));
                    });
                },
                401: function (res) {
                    const data = JSON.parse(res.responseText);

                    data.errors.forEach(error => {
                        $(`<p class="form-validation-error">${error}</p>`).insertBefore($(form).find('.login-register-buttons'));
                    });
                },
                500: function () {
                    $(`<p class="form-validation-error">Looks like something went wrong. Try again later.</p>`).insertBefore($(form).find('.login-register-buttons'));
                }
            }
        });
        
    });

    $(".btn-delete-url").on("click", function (e) {

        e.preventDefault();

        const id = $(this).attr("data-url-id");

        const listItem = $(this).closest(".my-links-list-item"); 

        const fullLink = $(listItem).find(".original-link a").text();

        Swal.fire({
            title: "Are you sure you want to delete the shortened link?",
            showCancelButton: true,
            confirmButtonText: "DELETE",
            cancelButtonText: "CANCEL",
            cancelButtonColor: "#FF0000",
            text: `This shortened links points to ${fullLink}.`
          }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/URLs',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    complete: function(res){
        
                        let res_data = JSON.parse(res.responseText);
                
                        if(res.status == 401){
                            window.location = "/login";
                        }
                        else if(res_data.success){
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The shortened link has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                              });

                              $(listItem).remove();
                        }
                        else if(res.status == 500){
                            Swal.fire({
                                title: 'Error!',
                                text: 'Looks like something went wrong. Please try again. If the issue persists, try again later.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                        else{
                            let errorText = "";
        
                            res_data.errors.forEach(error => {
                                errorText += error + " <br>";
                            });
        
                            Swal.fire({
                                title: 'Bad request!',
                                html: errorText,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
        
                    }
                });
              
            }

          });

    });

    $("#btn-register").on("click", function (e) {

        e.preventDefault();

        const form = $(".form-login-register");

        $(form).find(".form-validation-error").remove();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/register',
            type: 'POST',
            data: $(form).serialize(),
            statusCode: {
                201: function (res) {
                    window.location = "/my-links";
                },
                400: function (res) {
                    const data = JSON.parse(res.responseText);

                    data.errors.forEach(error => {
                        $(`<p class="form-validation-error">${error}</p>`).insertBefore($(form).find('.login-register-buttons'));
                    });
                },
                500: function () {
                    $(`<p class="form-validation-error">Looks like something went wrong. Try again later.</p>`).insertBefore($(form).find('.login-register-buttons'));
                }
            }
        });

    });

})