$(function() {
    $.get('/user/me/', function (response) {
        if (response.hasOwnProperty('logged_in')) {
            if (response['logged_in']) {
                var $avatar = $("#avatar");

                $avatar.parent().removeClass('col-md-0').addClass('col-md-1');
                $avatar.parents('.row').find('.col-md-10').addClass('col-md-9').removeClass('.col-md-10');
                $avatar.attr('src', response['picture_url']).removeClass('hide');
            } else {
                $("#login-button").removeClass('hide');
            }
        }
    });
});
