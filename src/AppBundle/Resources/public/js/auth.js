$(function() {
    $.get('/user/me/', function (response) {
        if (response.hasOwnProperty('logged_in')) {
            if (response['logged_in']) {
                var $avatar = $("#avatar");
                var avatarContainer = $avatar.parent();

                avatarContainer.removeClass('hide');
                $avatar.attr('src', response['picture_url']).removeClass('hide');
            } else {
                $("#login-button").removeClass('hide');
            }
        }
    });
});
