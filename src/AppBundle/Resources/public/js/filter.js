$(function () {
    function getDecodedUri() {
        var decoded = {},
            queryString = window.location.search;

        queryString = queryString.substring(queryString.indexOf('?') + 1).split('&');

        for (var i = queryString.length; i > 0;) {
            var pair = queryString[--i].split('='),
                key = decodeURIComponent(pair[0]),
                value = decodeURIComponent(pair[1])
                ;
            if (value.indexOf(',') !== -1) {
                var valueArray = new Array();
                valueArray = value.split(',');

                value = valueArray;
            } else {
                value = [ value ];
            }

            if (key) {
                decoded[key] = value;
            }
        }

        return decoded;
    }

    function getEncodedUri(params)
    {
        var encoded = '?';

        for (key in params) {
            encoded += key + '=' + params[key].join(',') + '&';
        }

        return encoded;
    }

    function addUrlElement(key, value) {
        var decodedUri = getDecodedUri();

        if (typeof(decodedUri[key]) === 'undefined') {
            decodedUri[key] = [];
        }

        if (decodedUri[key].indexOf(value) === -1) {
            decodedUri[key].push(value);
        }

        window.location.search = getEncodedUri(decodedUri);
    }

    function removeUrlElement(key, value) {
        var decodedUri = getDecodedUri(),
            value = String(value);

        if (typeof(decodedUri[key]) === 'undefined') {
            return;
        }

        if (decodedUri[key].indexOf(value) !== -1) {
            decodedUri[key].removeValue(value);
            if (decodedUri[key].length === 0) {
                delete decodedUri[key];
            }
        }

        window.location.search = getEncodedUri(decodedUri);
    }

    var filters = [
        { singular: 'field',    plural: 'fields'     },
        { singular: 'tag',      plural: 'tags'       },
        { singular: 'lecturer', plural: 'lecturers'  },
        { singular: 'event',    plural: 'events'     },
        { singular: 'lang',     plural: 'langs'     }
    ];

    for (var i in filters) {
        if (false === filters[i].hasOwnProperty('singular')) {
            continue;
        }

        //we need to encapsulate filterConfig, so use an anonymous function
        (function () {
            var filterConfig = filters[i];
            var select = $('#select-' + filterConfig.singular);

            $('.remove-' + filterConfig.singular).click(function () {
                removeUrlElement(filterConfig.plural, $(this).data('id'));
            });
            select.selectize({
                placeholder: select.data('selectize-placeholder') || 'Выбрать ...',
                'onItemAdd': function (id) {
                    addUrlElement(filterConfig.plural, id);
                }
            });
        })();
    }

    $('#lecture-filters').removeClass('hide');

    $('#toggle-filters')
        .tooltip()
        .click(function () {
            if ($(this).data('expanded') == 1) {
                $(this)
                    .data('expanded', 0)
                    .attr('data-original-title', 'Показать фильтры')
            } else {
                $(this)
                    .data('expanded', 1)
                    .attr('data-original-title', 'Скрыть фильтры')
            }
            $(this)
                .find('i')
                .toggleClass('fa-arrow-circle-up')
                .toggleClass('fa-arrow-circle-down')
            ;
        });

    $('img.video-thumbnail').click(function () {
        var iframe = $('<iframe/>')
            .attr('width', $(this).width())
            .attr('height', $(this).height())
            .attr('frameborderd', '0')
            .attr('src', $(this).data('iframe-url'))
            .css('background-color', '#000')
            .attr('allowfullscreen', '');
        $(this).after(iframe).remove();
    });
});
