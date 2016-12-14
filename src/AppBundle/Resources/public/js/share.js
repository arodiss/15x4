$(function() {
    var vkjs, fbjs, fjs = document.getElementsByTagName('script')[0];

    //fb share
    if (null == document.getElementById('facebook-jssdk')) {
        fbjs = document.createElement('script'); fbjs.id = 'facebook-jssdk';
        fbjs.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(fbjs, fjs);
    }

    //vk share
    if (null == document.getElementById('vk-jssdk')) {
        vkjs = document.createElement('script'); vkjs.id = 'vk-jssdk';
        vkjs.src = "//vk.com/js/api/share.js";
        vkjs.charset = "windows-1251";
        fjs.parentNode.insertBefore(vkjs, fjs);
    }
    setTimeout(
        function () {
            $(".vk-share-button").each(function () {
                $(this).html(VK.Share.button($(this).data('href'), {type: 'link'}));
            });
        },
        1000
    )
}(document));
