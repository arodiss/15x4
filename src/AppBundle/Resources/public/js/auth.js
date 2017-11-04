$(function() {
    $.get('/user/me/', function (response) {
        if (response.hasOwnProperty('logged_in')) {
            if (response['logged_in']) {
                var $avatar = $("#avatar");
                var avatarContainer = $avatar.parent();

                avatarContainer.removeClass('transparent');
                $avatar.attr('src', response['picture_url']);
            } else {
                $("#login-button").removeClass('d-none');
            }
        }
    });
});
