<?php

namespace AppBundle\Twig;

use AppBundle\Entity\ContactOld;

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
            ContactOld::CITY_MOSCOW => 'Москва',
            ContactOld::CITY_KIEV => 'Киев',
            ContactOld::CITY_KHARKOV => 'Харьков',
            ContactOld::CITY_LVIV => 'Львов',
            ContactOld::CITY_CHERNIVTSI => 'Черновцы',
            ContactOld::CITY_KISHENEV => 'Кишинёв',
            ContactOld::CITY_ODESSA => 'Одесса',
            ContactOld::CITY_SPB => 'Санкт-Петербург',
            ContactOld::CITY_SAMARA => 'Самара',
            ContactOld::CITY_MUNICH => 'Мюнхен',
            ContactOld::CITY_DNEPR => 'Днепр',
            ContactOld::CITY_TULA => 'Тула',
            ContactOld::CITY_KHMELNITSKIY => 'Хмельницкий',
            ContactOld::CITY_ZHITOMIR => 'Житомир',
            ContactOld::CITY_KNA => 'Комсомольск-на-Амуре',
            ContactOld::CITY_BELGOROD => 'Белгород',
            ContactOld::CITY_KAZAN => 'Казань',
            ContactOld::CITY_NOVOROSSIYSK => 'Новороссийск',
            ContactOld::CITY_MINSK => 'Минск',
            ContactOld::CITY_UU => 'Улан-Удэ',
            ContactOld::CITY_TOMSK => 'Томск',
        ];
    }

    /** @return array */
    public static function getContacts()
    {
        return [
            new ContactOld('Александр Гапак', ContactOld::CITY_KHARKOV, ContactOld::GOAL_FOUNDER,
                ['fb' => 'aleksandr.gapak', 'email' => 'wolfinnigth@gmail.com', 'vk' => 'alex_gapak'], 'gapak.jpg'),

            new ContactOld('Таня Погорецкая', ContactOld::CITY_KIEV, ContactOld::GOAL_LECTURER,
                ['email' => '15x4Kyiv@gmail.com', 'vk' => 'brunsweek'], 't-li.jpg'),

            new ContactOld('Глеб Сидора', ContactOld::CITY_KIEV, ContactOld::GOAL_WEBSITE,
                ['email' => 'gleb.sidora@gmail.com', 'vk' => 'arodiss', 'fb' => 'profile.php?id=100001049885258'], 'arodiss.jpg'),

            new ContactOld('Александра Малевич', ContactOld::CITY_KIEV, ContactOld::GOAL_COORDINATOR,
                ['email' => '15x4Kyiv@gmail.com', 'vk' => 'ehnara', 'fb' => 'ehnara'], 'ehnara.jpg'),

            new ContactOld('Ульяна Громова', ContactOld::CITY_KHARKOV, ContactOld::GOAL_VOLUNTEER,
                ['email' => 'Malyarchyk.17@gmail.com', 'vk' => 'hell_low'], 'gromova.jpg'),

            new ContactOld('Евгений Киося', ContactOld::CITY_KHARKOV, ContactOld::GOAL_LECTURER,
                ['email' => 'yevgenkiosya@gmail.com', 'vk' => 'yevgen_kiosya'], 'kiosya.jpg'),

            new ContactOld('Оксана Брошнівська', ContactOld::CITY_LVIV, ContactOld::GOAL_COORDINATOR,
                ['email' => 'oksanabro93@gmail.com', 'vk' => 'do___bro', 'fb' => 'oksana.broshnivska'], 'oksana_lvov.jpg'),

            new ContactOld('Валерия Грачёва', ContactOld::CITY_MOSCOW, ContactOld::GOAL_COORDINATOR,
                ['email' => 'eon@houston.ru', 'vk' => 'real_night', 'fb' => 'realgrachova'], 'real.jpg'),

            new ContactOld('Станислав Романюк', ContactOld::CITY_CHERNIVTSI, ContactOld::GOAL_COORDINATOR,
                ['email' => 'masterofstature@gmail.com', 'vk' => 'rm_nk', 'fb' => 'romanyuker'], 'stanislav.jpg'),

            new ContactOld('Марьяна Торкиш', ContactOld::CITY_CHERNIVTSI, ContactOld::GOAL_VOLUNTEER,
                ['email' => 'morkishka@gmail.com', 'vk' => 'bgtor'], 'tor.jpg'),

            new ContactOld('Артём Трач', ContactOld::CITY_KISHENEV, ContactOld::GOAL_LECTURER,
                ['email' => 'artoliver@yandex.ru', 'vk' => 'artoliver', 'fb' => 'oliver.trach'], 'trach.jpg'),

            new ContactOld('Лина Батарчукова', ContactOld::CITY_KISHENEV, ContactOld::GOAL_VOLUNTEER,
                ['email' => 'polina.kirin@gmail.com', 'vk' => 'kirin.lina', 'fb' => 'lina.kirin'], 'batarchukova.jpg'),

            new ContactOld('Артур Ковач', ContactOld::CITY_KISHENEV, ContactOld::GOAL_COORDINATOR,
                ['email' => 'sh-432@mail.ru', 'vk' => 'arturkovach', 'fb' => 'profile.php?id=100010702322735']),

            new ContactOld('Елена Гомон', ContactOld::CITY_CHERNIVTSI, ContactOld::GOAL_LECTURER,
                ['email' => 'ellengomon@gmail.com', 'vk' => 'id32493096', 'fb' => 'elena.gomon.54'], 'gaechka.jpg'),

            new ContactOld('Александр Карлов', ContactOld::CITY_ODESSA, ContactOld::GOAL_COORDINATOR,
                ['email' => 'alex.karlov34@gmail.com', 'vk' => 'alex_karlov34', 'fb' => 'aleksandr.karlov'], 'karlos.jpg'),

            new ContactOld('Елизавета Бабицкая', ContactOld::CITY_SPB, ContactOld::GOAL_COORDINATOR,
                ['email' => 'elizaveta41271@rambler.ru', 'vk' => 'lizailonen', 'fb' => 'elizaveta.babitskaya'], 'lizailonen.jpg'),

            new ContactOld('Александра Артёмова', ContactOld::CITY_SAMARA, ContactOld::GOAL_COORDINATOR,
                ['email' => 'ao.artemova@mail.ru', 'vk' => 'artemova.aleksandra', 'fb' => 'black.persey'], 'artemova.jpg'),

            new ContactOld('Алексей Зиновьев', ContactOld::CITY_MUNICH, ContactOld::GOAL_COORDINATOR,
                ['email' => 'munich@15x4.org', 'vk' => 'ash4ever', 'fb' => 'zinovev.aleksei'], 'az.jpg'),

            new ContactOld('Алексей Разбаков', ContactOld::CITY_MUNICH, ContactOld::GOAL_COORDINATOR,
                ['email' => 'razbakov@15x4.org.com', 'vk' => 'razbakov', 'fb' => 'razbakov'], 'razbakov.jpg'),

            new ContactOld('Виктория Коржова', ContactOld::CITY_MUNICH, ContactOld::GOAL_LECTURER,
                ['email' => 'viktoria.korzhova@gmail.com', 'vk' => 'viktoria.korzhova', 'fb' => 'viktoria.v.korzhova'], 'victoria_munich.jpg'),

            new ContactOld('Яна Бондарчук', ContactOld::CITY_KHMELNITSKIY, ContactOld::GOAL_COORDINATOR,
                ['email' => '15x4khm@gmail.com', 'vk' => 'yasna_yana', 'fb' => 'profile.php?id=100011673760027'], 'yana_khmel.jpg'),

            new ContactOld('Ива', ContactOld::CITY_DNEPR, ContactOld::GOAL_COORDINATOR,
                ['email' => 'k.nay@mail.ru', 'vk' => 'ivatelesik'], 'iva_dnepr.jpg'),

            new ContactOld('Надія Коваль', ContactOld::CITY_DNEPR, ContactOld::GOAL_COORDINATOR,
                ['email' => 'nadiiakoval@gmail.com', 'vk' => 'nadiako', 'fb' => 'nadiiakoval'], 'nadia_dnepr.jpg'),

            new ContactOld('Игорь Страх', ContactOld::CITY_MINSK, ContactOld::GOAL_COORDINATOR,
                ['vk' => 'impirator'], 'igor_minsk.jpg'),

            new ContactOld('Ника Верховенко', ContactOld::CITY_BELGOROD, ContactOld::GOAL_COORDINATOR,
                ['email' => 'nikakoks039@gmail.com', 'vk' => 'my_reself'], 'nika_belgorod.jpg'),

            new ContactOld('Елена Паренюк', ContactOld::CITY_BELGOROD, ContactOld::GOAL_COORDINATOR,
                ['email' => 'olena.pareniuk@gmail.com', 'vk' => 'id6536342', 'fb' => 'elena.pareniuk'], 'elena_zh.jpg'),

            new ContactOld('Айрат Садыков', ContactOld::CITY_KAZAN, ContactOld::GOAL_COORDINATOR,
                ['email' => 'sadykov.airat@gmail.com', 'vk' => 'airat.sadykov', 'fb' => 'airat.sadykov'], 'airat.jpg'),

            new ContactOld('Евгений Царицанский', ContactOld::CITY_NOVOROSSIYSK, ContactOld::GOAL_COORDINATOR,
                ['email' => 'tsar1305@gmail.com', 'vk' => 'evgtsar', 'fb' => 'profile.php?id=100011499874809'], 'eugen_nrs.jpg'),

            new ContactOld('Эрик Янцевич', ContactOld::CITY_KNA, ContactOld::GOAL_COORDINATOR,
                ['email' => 'mostlyerik@gmail.com', 'vk' => 'erik_yan', 'fb' => 'erik.yancevich'], 'eric_kna.jpg'),

            new ContactOld('Александр Хамнушкин', ContactOld::CITY_UU, ContactOld::GOAL_COORDINATOR,
                ['vk' => 'saygut'], 'alexander_uu.jpg'),

            new ContactOld('Пурбо Дамбиев', ContactOld::CITY_UU, ContactOld::GOAL_COORDINATOR,
                ['email' => 'purboxa@mail.ru', 'vk' => 'id197981549'], 'purbo_uu.jpg'),

            new ContactOld('Екатерина Гапон', ContactOld::CITY_TOMSK, ContactOld::GOAL_COORDINATOR,
                ['email' => 'gapon12@icloud.com', 'vk' => 'id24185330', 'fb' => 'profile.php?id=100000928378788'], 'ekaterina_tsk.jpg'),

            new ContactOld('Олеся Михайлова', ContactOld::CITY_TOMSK, ContactOld::GOAL_COORDINATOR,
                ['email' => 'mihailova.olesyaa@yandex.ru', 'vk' => 'id30613945'], 'olesya_tomsk.jpg'),

            new ContactOld('Константин Дьяченко', ContactOld::CITY_TULA, ContactOld::GOAL_COORDINATOR,
                ['email' => 'odin_4@mail.ru', 'vk' => 'id169066349', 'fb' => 'constantin.dyachenko'], 'konstantin_tl.jpg'),

            new ContactOld('Ким Аристов', ContactOld::CITY_TULA, ContactOld::GOAL_VOLUNTEER,
                ['email' => 'aristov@yandeх.ru', 'vk' => 'kim_aristov', 'fb' => 'kim.aristov'], 'kim_tl.jpg'),

            new ContactOld('Татьяна Максимова', ContactOld::CITY_TULA, ContactOld::GOAL_LECTURER,
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
