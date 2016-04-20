$(function() {
    function getRandomScientist() {
        return ['Бертран Рассел', 'Норберт Винер', 'Даниэль Каннеман', 'Альберт Эйнштейн',
            'Ричард Докинз', 'Людвиг Витгенштейн', 'Курт Гёдель', 'Никола Тесла', 'Стивен Хокинг',
            'Бенуа Мандельброт', 'Вернер Гейзенберг', 'Нильс Бор', 'Ричард Фейнман', 'Илья Пригожин',
            'Доктор Стрейнджлав', 'Ноам Хомский', 'Джон Нэш', 'Давид Гильберт', 'Чарльз Дарвин', 'Георг Кантор',
            'Александр Флеминг', 'Карл Поппер', 'Марвин Мински', 'Алан Тьюринг'].random();
    }

    $('.sign-up').click(function() {
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
                container.html('<i>Спасибо за регистрацию</i>');
            }
        });

        return false;
    });
});
