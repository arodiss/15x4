$(function() {
    $('.like').click(function () {
        if ($(this).is('.disabled')) {
            return;
        }

        var likeCounter = $(this).parents('.lecture-reactions').find('.like-count');
        likeCounter.text(parseInt(likeCounter.text()) + 1);
        $(this).css('color', 'orangered').removeClass('cursor-pointer').addClass('disabled');
        $(this).parents('.lecture-reactions').find('.dislike').css('color', 'gray').removeClass('cursor-pointer').addClass('disabled');

        $.get(
            '/react/' + $(this).parents('.lecture-reactions').data('lecture-id'),
            { 'reaction': 'like' }
        );
    });

    $('.dislike').click(function () {
        if ($(this).is('.disabled')) {
            return;
        }

        var dislikeCounter = $(this).parents('.lecture-reactions').find('.dislike-count');
        dislikeCounter.text(parseInt(dislikeCounter.text()) + 1);
        $(this).css('color', 'orangered').removeClass('cursor-pointer').addClass('disabled');
        $(this).parents('.lecture-reactions').find('.like').css('color', 'gray').removeClass('cursor-pointer').addClass('disabled');

        $.get(
            '/react/' + $(this).parents('.lecture-reactions').data('lecture-id'),
            { 'reaction': 'dislike' }
        );
    });

    $('.favorite').click(function () {
        if ($(this).is('.disabled')) {
            return;
        }

        var favsCounter = $(this).parents('.lecture-reactions').find('.fav-count'),
            path;
        if ($(this).is('.favorited')) {
            path = '/unfav/';
            favsCounter.text(parseInt(favsCounter.text()) - 1);
            $(this).css('color', '');
        } else {
            path = '/fav/';
            favsCounter.text(parseInt(favsCounter.text()) + 1);
            $(this).css('color', 'orangered');
        }

        $.get(path + $(this).parents('.lecture-reactions').data('lecture-id'));
        $(this).removeClass('cursor-pointer').addClass('disabled');
    });
});
