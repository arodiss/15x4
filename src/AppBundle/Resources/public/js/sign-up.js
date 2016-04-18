$(function() {
    function getRandomScientist() {
        return ['Бертран Рассел', 'Норберт Виннер', 'Даниэль Каннеман', 'Альберт Эйнштейн',
            'Ричард Докинз', 'Людвиг Витгенштейн', 'Курт Гёдель', 'Никола Тесла', 'Стивен Хокинг',
            'Бенуа Мандельброт', 'Вернер Гейзенберг', 'Нильс Бор', 'Ричард Фейнман', 'Илья Пригожин',
            'Доктор Стрейнджлав', 'Ноам Хомский', 'Джон Нэш', 'Давид Гильберт', 'Чарльз Дарвин', 'Георг Кантор',
            'Александр Флеминг', 'Карл Поппер'].random();
    }

    $('.sign-up').click(function() {
        var container = $(this).parents('p');

        container.html($('#sign-up-details').html());

        container.find('#ticket_name').attr('placeholder', getRandomScientist());

        container.find('.book-ticket').click(function() {
            if (container.find('#ticket_name').val()) {
                $.get(
                    '/sign-up/' + container.data('event-id'),
                    {
                        'name': container.find('#ticket_name').val(),
                        'count': parseInt(container.find('#ticket_number').val()) + 1
                    }
                );
                container.html('<i>Спасибо за регистрацию</i>');
            }
        });

        return false;
    });
});
