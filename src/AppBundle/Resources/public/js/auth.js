$(function() {
    $.get('/user/me/', function (response) {
        if (response.hasOwnProperty('logged_in')) {
            if (response['logged_in']) {
                var $avatar = $("#avatar");

                $avatar.parent().removeClass('col-lg-0').addClass('col-lg-1');
                $avatar.parents('.row').find('.col-lg-8').addClass('col-lg-7').removeClass('.col-lg-8');
                $avatar.attr('src', response['picture_url']).removeClass('hide');
            } else {
                $("#login-button").removeClass('hide');
            }
        }
    });
});
