$(function () {

    $("#mobile-menu-toggler").on("click", function () {
        $("nav").slideToggle();
    });

    $(".accordion-title").on("click", function () {
        $(this).siblings(".accordion-content").slideToggle();
    });

    $(".copy-shortened-link").on("click", function () {
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

})