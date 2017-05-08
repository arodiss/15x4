<?php

namespace AppBundle\Entity;

class Contact
{
    const DEFAULT_PICTURE = '../logo.png';

    const CITY_MOSCOW = 1;
    const CITY_KIEV = 2;
    const CITY_KHARKOV = 3;
    const CITY_LVIV = 4;
    const CITY_CHERNIVTSI = 5;
    const CITY_KISHENEV = 6;
    const CITY_ODESSA = 7;
    const CITY_SPB = 8;
    const CITY_SAMARA = 9;
    const CITY_MUNICH = 10;
    const CITY_DNEPR = 11;
    const CITY_TULA = 12;
    const CITY_KHMELNITSKIY = 13;
    const CITY_ZHITOMIR = 14;
    const CITY_KNA = 15;
    const CITY_BELGOROD = 16;
    const CITY_KAZAN = 17;
    const CITY_NOVOROSSIYSK = 18;
    const CITY_MINSK = 19;
    const CITY_UU = 20;
    const CITY_TOMSK = 21;
    
    const GOAL_FOUNDER = 'Основатель и глобальный координатор';
    const GOAL_LECTURER = 'Работа с лекторами';
    const GOAL_VOLUNTEER = 'Работа с волонтёрами';
    const GOAL_COORDINATOR = 'Координатор отделения';
    const GOAL_WEBSITE = 'Разработка сайта';
    const GOAL_MEDIA = 'Связь со СМИ';

    /** @var string */
    private $picture;

    /** @var string */
    private $goal;

    /** @var int */
    private $city;

    /** @var string */
    private $name;

    /** @var string */
    private $fb;

    /** @var string */
    private $vk;

    /** @var string */
    private $email;

    /**
     * @param string $name
     * @param int $city
     * @param string $goal
     * @param array|string[] $contacts
     * @param string $picture
     */
    public function __construct($name, $city, $goal, array $contacts, $picture = self::DEFAULT_PICTURE)
    {
        $this->name = $name;
        $this->city = $city;
        $this->goal = $goal;
        $this->picture = $picture;
        if (isset($contacts['fb'])) {
            $this->fb = $contacts['fb'];
        }
        if (isset($contacts['vk'])) {
            $this->vk = $contacts['vk'];
        }
        if (isset($contacts['email'])) {
            $this->email = $contacts['email'];
        }
    }

    /** @return string */
    public function getPicture()
    {
        return $this->picture;
    }

    /** @return string */
    public function getGoal()
    {
        return $this->goal;
    }

    /** @return int */
    public function getCity()
    {
        return $this->city;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @return string */
    public function getVk()
    {
        return $this->vk;
    }

    /** @return string */
    public function getEmail()
    {
        return $this->email;
    }

    /** @return string */
    public function getFb()
    {
        return $this->fb;
    }

    public static function getAllGoals()
    {
        return [
            self::GOAL_COORDINATOR,
            self::GOAL_FOUNDER,
            self::GOAL_LECTURER,
            self::GOAL_VOLUNTEER,
            self::GOAL_WEBSITE,
            self::GOAL_MEDIA,
        ];
    }

    /** @return array */
    public function getGoalsData()
    {
        switch ($this->getGoal()) {
            case self::GOAL_COORDINATOR:
                return [
                    'lecturer' => [$this->getCity()],
                    'volunteer' => [$this->getCity()],
                ];
            case self::GOAL_FOUNDER:
                return [
                    'other' => [],
                    'branch' => [],
                ];
            case self::GOAL_LECTURER:
                return [ 
                    'lecturer' => [$this->getCity()],
                ];
            case self::GOAL_VOLUNTEER:
                return [
                    'volunteer' => [$this->getCity()],
                ];
            case self::GOAL_WEBSITE:
                return [
                    'site' => [],
                ];
            case self::GOAL_MEDIA:
                return [
                    'other' => [],
                ];
            default:
                throw new \InvalidArgumentException(sprintf('Unknown goal `%s`', $this->getGoal()));
        }
    }
}
