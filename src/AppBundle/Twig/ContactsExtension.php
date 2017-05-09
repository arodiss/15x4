<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Contact;

class ContactsExtension extends \Twig_Extension
{
    /** {@inheritDoc} */
    public function getName()
    {
        return 'contacts';
    }

    /** {@inheritDoc} */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_contact_cities', [$this, 'getCities']),
            new \Twig_SimpleFunction('get_contacts', [$this, 'getContacts']),
        ];
    }

    /** {@inheritDoc} */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('contact_city', [$this, 'getContactCity']),
        ];
    }

    /** @return array */
    public static function getCities()
    {
        return [
            Contact::CITY_MOSCOW => 'Москва',
            Contact::CITY_KIEV => 'Киев',
            Contact::CITY_KHARKOV => 'Харьков',
            Contact::CITY_LVIV => 'Львов',
            Contact::CITY_CHERNIVTSI => 'Черновцы',
            Contact::CITY_KISHENEV => 'Кишенёв',
            Contact::CITY_ODESSA => 'Одесса',
            Contact::CITY_SPB => 'Санкт-Петербург',
            Contact::CITY_SAMARA => 'Самара',
            Contact::CITY_MUNICH => 'Мюнхен',
            Contact::CITY_DNEPR => 'Днепр',
            Contact::CITY_TULA => 'Тула',
            Contact::CITY_KHMELNITSKIY => 'Хмельницкий',
            Contact::CITY_ZHITOMIR => 'Житомир',
            Contact::CITY_KNA => 'Комсомольск-на-Амуре',
            Contact::CITY_BELGOROD => 'Белгород',
            Contact::CITY_KAZAN => 'Казань',
            Contact::CITY_NOVOROSSIYSK => 'Новороссийск',
            Contact::CITY_MINSK => 'Минск',
            Contact::CITY_UU => 'Улан-Удэ',
            Contact::CITY_TOMSK => 'Томск',
        ];
    }

    /** @return array */
    public static function getContacts()
    {
        return [
            new Contact('Александр Гапак', Contact::CITY_KHARKOV, Contact::GOAL_FOUNDER,
                ['fb' => 'aleksandr.gapak', 'email' => 'wolfinnigth@gmail.com', 'vk' => 'alex_gapak'], 'gapak.jpg'),

            new Contact('Таня Погорецкая', Contact::CITY_KIEV, Contact::GOAL_LECTURER,
                ['email' => '15x4Kyiv@gmail.com', 'vk' => 'brunsweek'], 't-li.jpg'),

            new Contact('Глеб Сидора', Contact::CITY_KIEV, Contact::GOAL_WEBSITE,
                ['email' => 'gleb.sidora@gmail.com', 'vk' => 'arodiss', 'fb' => 'profile.php?id=100001049885258'], 'arodiss.jpg'),

            new Contact('Александра Малевич', Contact::CITY_KIEV, Contact::GOAL_COORDINATOR,
                ['email' => '15x4Kyiv@gmail.com', 'vk' => 'ehnara', 'fb' => 'ehnara'], 'ehnara.jpg'),

            new Contact('Ульяна Громова', Contact::CITY_KHARKOV, Contact::GOAL_VOLUNTEER,
                ['email' => 'Malyarchyk.17@gmail.com', 'vk' => 'hell_low'], 'gromova.jpg'),

            new Contact('Евгений Киося', Contact::CITY_KHARKOV, Contact::GOAL_LECTURER,
                ['email' => 'yevgenkiosya@gmail.com', 'vk' => 'yevgen_kiosya'], 'kiosya.jpg'),

            new Contact('Оксана Брошнівська', Contact::CITY_LVIV, Contact::GOAL_COORDINATOR,
                ['email' => 'oksanabro93@gmail.com', 'vk' => 'do___bro', 'fb' => 'oksana.broshnivska'], 'oksana_lvov.jpg'),

            new Contact('Валерия Грачёва', Contact::CITY_MOSCOW, Contact::GOAL_COORDINATOR,
                ['email' => 'eon@houston.ru', 'vk' => 'real_night', 'fb' => 'realgrachova'], 'real.jpg'),

            new Contact('Станислав Романюк', Contact::CITY_CHERNIVTSI, Contact::GOAL_COORDINATOR,
                ['email' => 'masterofstature@gmail.com', 'vk' => 'rm_nk', 'fb' => 'romanyuker'], 'stanislav.jpg'),

            new Contact('Марьяна Торкиш', Contact::CITY_CHERNIVTSI, Contact::GOAL_VOLUNTEER,
                ['email' => 'morkishka@gmail.com', 'vk' => 'bgtor'], 'tor.jpg'),

            new Contact('Артём Трач', Contact::CITY_KISHENEV, Contact::GOAL_LECTURER,
                ['email' => 'artoliver@yandex.ru', 'vk' => 'artoliver', 'fb' => 'oliver.trach'], 'trach.jpg'),

            new Contact('Лина Батарчукова', Contact::CITY_KISHENEV, Contact::GOAL_VOLUNTEER,
                ['email' => 'polina.kirin@gmail.com', 'vk' => 'kirin.lina', 'fb' => 'lina.kirin'], 'batarchukova.jpg'),

            new Contact('Артур Ковач', Contact::CITY_KISHENEV, Contact::GOAL_COORDINATOR,
                ['email' => 'sh-432@mail.ru', 'vk' => 'arturkovach', 'fb' => 'profile.php?id=100010702322735']),

            new Contact('Елена Гомон', Contact::CITY_CHERNIVTSI, Contact::GOAL_LECTURER,
                ['email' => 'ellengomon@gmail.com', 'vk' => 'id32493096', 'fb' => 'elena.gomon.54'], 'gaechka.jpg'),

            new Contact('Александр Карлов', Contact::CITY_ODESSA, Contact::GOAL_COORDINATOR,
                ['email' => 'alex.karlov34@gmail.com', 'vk' => 'alex_karlov34', 'fb' => 'aleksandr.karlov'], 'karlos.jpg'),

            new Contact('Елизавета Бабицкая', Contact::CITY_SPB, Contact::GOAL_COORDINATOR,
                ['email' => 'elizaveta41271@rambler.ru', 'vk' => 'lizailonen', 'fb' => 'elizaveta.babitskaya'], 'lizailonen.jpg'),

            new Contact('Александра Артёмова', Contact::CITY_SAMARA, Contact::GOAL_COORDINATOR,
                ['email' => 'ao.artemova@mail.ru', 'vk' => 'artemova.aleksandra', 'fb' => 'black.persey'], 'artemova.jpg'),

            new Contact('Алексей Зиновьев', Contact::CITY_MUNICH, Contact::GOAL_COORDINATOR,
                ['email' => 'munich@15x4.org', 'vk' => 'ash4ever', 'fb' => 'zinovev.aleksei'], 'az.jpg'),

            new Contact('Алексей Разбаков', Contact::CITY_MUNICH, Contact::GOAL_COORDINATOR,
                ['email' => 'razbakov@15x4.org.com', 'vk' => 'razbakov', 'fb' => 'razbakov'], 'razbakov.jpg'),

            new Contact('Виктория Коржова', Contact::CITY_MUNICH, Contact::GOAL_LECTURER,
                ['email' => 'viktoria.korzhova@gmail.com', 'vk' => 'viktoria.korzhova', 'fb' => 'viktoria.v.korzhova'], 'victoria_munich.jpg'),

            new Contact('Яна Бондарчук', Contact::CITY_KHMELNITSKIY, Contact::GOAL_COORDINATOR,
                ['email' => '15x4khm@gmail.com', 'vk' => 'yasna_yana', 'fb' => 'profile.php?id=100011673760027'], 'yana_khmel.jpg'),

            new Contact('Ива', Contact::CITY_DNEPR, Contact::GOAL_COORDINATOR,
                ['email' => 'k.nay@mail.ru', 'vk' => 'ivatelesik'], 'iva_dnepr.jpg'),

            new Contact('Надя Коваль', Contact::CITY_DNEPR, Contact::GOAL_VOLUNTEER,
                ['email' => 'nadiiakoval@gmail.com', 'vk' => 'nadiako', 'fb' => 'nadiiakoval'], 'nadia_dnepr.jpg'),

            new Contact('Игорь Страх', Contact::CITY_MINSK, Contact::GOAL_COORDINATOR,
                ['vk' => 'impirator'], 'igor_minsk.jpg'),

            new Contact('Ника Верховенко', Contact::CITY_BELGOROD, Contact::GOAL_COORDINATOR,
                ['email' => 'nikakoks039@gmail.com', 'vk' => 'my_reself'], 'nika_belgorod.jpg'),

            new Contact('Елена Паренюк', Contact::CITY_BELGOROD, Contact::GOAL_COORDINATOR,
                ['email' => 'olena.pareniuk@gmail.com', 'vk' => 'id6536342', 'fb' => 'elena.pareniuk'], 'elena_zh.jpg'),

            new Contact('Айрат Садыков', Contact::CITY_KAZAN, Contact::GOAL_COORDINATOR,
                ['email' => 'sadykov.airat@gmail.com', 'vk' => 'airat.sadykov', 'fb' => 'airat.sadykov'], 'airat.jpg'),

            new Contact('Евгений Царицанский', Contact::CITY_NOVOROSSIYSK, Contact::GOAL_COORDINATOR,
                ['email' => 'tsar1305@gmail.com', 'vk' => 'evgtsar', 'fb' => 'profile.php?id=100011499874809'], 'eugen_nrs.jpg'),

            new Contact('Эрик Янцевич', Contact::CITY_KNA, Contact::GOAL_COORDINATOR,
                ['email' => 'mostlyerik@gmail.com', 'vk' => 'erik_yan', 'fb' => 'erik.yancevich'], 'eric_kna.jpg'),

            new Contact('Александр Хамнушкин', Contact::CITY_UU, Contact::GOAL_COORDINATOR,
                ['vk' => 'saygut'], 'alexander_uu.jpg'),

            new Contact('Пурбо Дамбиев', Contact::CITY_UU, Contact::GOAL_COORDINATOR,
                ['email' => 'purboxa@mail.ru', 'vk' => 'id197981549'], 'purbo_uu.jpg'),

            new Contact('Екатерина Гапон', Contact::CITY_TOMSK, Contact::GOAL_COORDINATOR,
                ['email' => 'gapon12@icloud.com', 'vk' => 'id24185330', 'fb' => 'profile.php?id=100000928378788'], 'ekaterina_tsk.jpg'),

            new Contact('Олеся Михайлова', Contact::CITY_TOMSK, Contact::GOAL_COORDINATOR,
                ['email' => 'mihailova.olesyaa@yandex.ru', 'vk' => 'id30613945'], 'olesya_tomsk.jpg'),

            new Contact('Константин Дьяченко', Contact::CITY_TULA, Contact::GOAL_COORDINATOR,
                ['email' => 'odin_4@mail.ru', 'vk' => 'id169066349', 'fb' => 'constantin.dyachenko'], 'konstantin_tl.jpg'),

            new Contact('Ким Аристов', Contact::CITY_TULA, Contact::GOAL_VOLUNTEER,
                ['email' => 'aristov@yandeх.ru', 'vk' => 'kim_aristov', 'fb' => 'kim.aristov'], 'kim_tl.jpg'),

            new Contact('Татьяна Максимова', Contact::CITY_TULA, Contact::GOAL_LECTURER,
                ['vk' => 'mtv_71', 'fb' => 'profile.php?id=100004404150884'], 'tatiana_tula.jpg'),
        ];
    }

    /**
     * @param int $id
     * @return string
     */
    public static function getContactCity($id)
    {
        return self::getCities()[$id];
    }
}
