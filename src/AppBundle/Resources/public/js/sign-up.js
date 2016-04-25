$(function() {
    function getRandomScientist() {
        return ['Бертран Рассел', 'Норберт Винер', 'Даниэль Каннеман', 'Альберт Эйнштейн',
            'Ричард Докинз', 'Людвиг Витгенштейн', 'Курт Гёдель', 'Никола Тесла', 'Стивен Хокинг',
            'Бенуа Мандельброт', 'Вернер Гейзенберг', 'Нильс Бор', 'Ричард Фейнман', 'Илья Пригожин',
            'Доктор Стрейнджлав', 'Ноам Хомский', 'Джон Нэш', 'Давид Гильберт', 'Чарльз Дарвин', 'Георг Кантор',
            'Александр Флеминг', 'Карл Поппер', 'Марвин Мински', 'Алан Тьюринг'].random();
    }

    function updateEventStatus(eventId) {
        $.get('/sign-up/' + eventId + '/conditions/', function (response) {
            if (response['registerable']) {
                if (response['tickets_left']) {
                    openSignUp(eventId);
                } else {
                    noTicketsLeft(eventId);
                }
            } else {
                noSignUp(eventId);
            }
        });
    }

    function getSignUpBlock(eventId) {
        var signUpBlocks = $('.event-sign-up');

        for (var blockIndex in signUpBlocks) {
            var block = $(signUpBlocks[blockIndex]);

            if (block.data('event-id') === eventId) {
                return block;
            }
        }
    }

    function noSignUp(eventId) {
        getSignUpBlock(eventId).text('Регистрация не требуется');
    }

    function noTicketsLeft(eventId) {
        getSignUpBlock(eventId).text('К сожалению, свободных мест для регистрации нет. Вы можете приходить, но мы не обещаем вам сидячее место');
    }

    function openSignUp(eventId) {
        var signUpBlock = getSignUpBlock(eventId);

        signUpBlock.html('<a class="sign-up" href="#">Зарегистрируйтесь</a>, пока ещё есть места');
        attachSignUpListener(signUpBlock);
    }

    function attachSignUpListener(signUpBlock) {
        $(signUpBlock).find('.sign-up').click(function() {
            var container = $(this).parents('p');

            container.html($('#sign-up-details').html());

            container.find('#ticket_name').attr('placeholder', getRandomScientist());

            container.find('#signup-volunteer').change(function () {
                $("#signup-contact-wrapper").toggleClass('hide');
            });

            container.find('.book-ticket').click(function() {
                if (container.find('#ticket_name').val()) {
                    $.get(
                        '/sign-up/' + container.data('event-id'),
                        {
                            'name': container.find('#ticket_name').val(),
                            'count': parseInt(container.find('#ticket_number').val()) + 1,
                            'contact': container.find('#contact').val()
                        }
                    );
                    container.html('<b><u>Спасибо за регистрацию</u></b>');
                }
            });

            return false;
        });
    }

    $('.event-sign-up').each(function (index, element) {
        updateEventStatus($(element).data('event-id'));
    });
});
