$(function () {
    
    $("#mobile-menu-toggler").on("click", function () {
        $("nav").slideToggle();
    });

    $(".shorten-url-form").on("submit", function(e){

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
                    
                },
                400: function (res) {
                    const data = JSON.parse(res.responseText);

                    data.errors.forEach(error => {
                        $(`<p class="form-validation-error">${error}</p>`).insertBefore($(form).find('input[type="submit"]'));
                    });
                },
                500: function (){
                    $(`<p class="form-validation-error">Looks like something went wrong. Try again later.</p>`).insertBefore($(form).find('input[type="submit"]'));
                }
            }
        });

    });

})