$(function() {
    function increaseLikeCounter(lectureNode) {
        var likeCounter = lectureNode.find('.like-count');

        likeCounter.text(parseInt(likeCounter.text()) + 1);
        lectureNode.find('.like').addClass('active');
    }

    function increaseDislikeCounter(lectureNode) {
        var dislikeCounter = lectureNode.find('.dislike-count');

        dislikeCounter.text(parseInt(dislikeCounter.text()) + 1);
        lectureNode.find('.dislike').addClass('active');
    }

    function removeLike(lectureNode) {
        var likeButton = lectureNode.find('.like');

        if (likeButton.is('.active')) {
            var likeCounter = lectureNode.find('.like-count');

            likeCounter.text(parseInt(likeCounter.text()) - 1);
            likeButton.removeClass('active');
        }
    }

    function removeDislike(lectureNode) {
        var dislikeButton = lectureNode.find('.dislike');

        if (dislikeButton.is('.active')) {
            var dislikeCounter = lectureNode.find('.dislike-count');

            dislikeCounter.text(parseInt(dislikeCounter.text()) - 1);
            dislikeButton.removeClass('active');
        }
    }

    function sendReaction(lectureNode, reaction) {
        $.get(
            '/react/' + lectureNode.data('lecture-id'),
            { 'reaction': reaction }
        );
    }

    function removeReaction(lectureNode) {
        $.get('/unreact/' + lectureNode.data('lecture-id'));
    }

    $('.like').click(function () {
        var lectureNode = $(this).parents('.lecture-reactions');

        if ($(this).is('.active')) {
            removeLike(lectureNode);
            removeReaction(lectureNode);
        } else {
            increaseLikeCounter(lectureNode);
            removeDislike(lectureNode);
            sendReaction(lectureNode, 'like');
        }
    });

    $('.dislike').click(function () {
        var lectureNode = $(this).parents('.lecture-reactions');

        if ($(this).is('.active')) {
            removeDislike(lectureNode);
            removeReaction(lectureNode);
        } else {
            increaseDislikeCounter(lectureNode);
            removeLike(lectureNode);
            sendReaction(lectureNode, 'dislike');
        }
    });

    $('.favorite').click(function () {
        var favsCounter = $(this).parents('.lecture-reactions').find('.fav-count'),
            path;
        if ($(this).is('.active')) {
            path = '/unfav/';
            favsCounter.text(parseInt(favsCounter.text()) - 1);
            $(this).removeClass('active');
        } else {
            path = '/fav/';
            favsCounter.text(parseInt(favsCounter.text()) + 1);
            $(this).addClass('active');
        }

        $.get(path + $(this).parents('.lecture-reactions').data('lecture-id'));
    });
});
