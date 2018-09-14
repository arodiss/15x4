<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ContactRepository")
 */
class Contact
{
    const DEFAULT_PICTURE = '../logo.png';
    
    const GOAL_FOUNDER = 'Основатель и глобальный координатор';
    const GOAL_LECTURER = 'Работа с лекторами';
    const GOAL_VOLUNTEER = 'Работа с волонтёрами';
    const GOAL_COORDINATOR = 'Координатор отделения';
    const GOAL_WEBSITE = 'Разработка сайта';
    const GOAL_MEDIA = 'Связь со СМИ';

    const GOALS_GLOBAL = [self::GOAL_FOUNDER, self::GOAL_WEBSITE, self::GOAL_MEDIA];

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="picture", type="string", length=63, nullable=true)
     */
    private $picture = self::DEFAULT_PICTURE;

    /**
     * @ORM\Column(name="goal", type="string", length=63, nullable=false)
     */
    private $goal;

    /**
     * @var City
     * @ORM\ManyToOne(
     *  targetEntity="City",
     *  inversedBy="contacts"
     * )
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $city;

    /**
     * @ORM\Column(name="name", type="string", length=63, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="fb", type="string", length=63, nullable=true)
     */
    private $fb;

    /**
     * @ORM\Column(name="vk", type="string", length=63, nullable=true)
     */
    private $vk;

    /**
     * @ORM\Column(name="telegram", type="string", length=63, nullable=true)
     */
    private $telegram;

    /**
     * @ORM\Column(name="email", type="string", length=63, nullable=true)
     */
    private $email;

    /** @return array|string[] */
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

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return string|null */
    public function getPicture()
    {
        return $this->picture ?: self::DEFAULT_PICTURE;
    }

    /** @param string $picture */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /** @return string */
    public function getGoal()
    {
        return $this->goal;
    }

    /** @param string $goal */
    public function setGoal($goal)
    {
        $this->goal = $goal;
    }

    /** @return City */
    public function getCity()
    {
        return $this->city;
    }

    /** @param City $city */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @param string $name */
    public function setName($name)
    {
        $this->name = $name;
    }

    /** @return string */
    public function getFb()
    {
        return $this->fb;
    }

    /** @param string $fb */
    public function setFb($fb)
    {
        $this->fb = $fb;
    }

    /** @return string */
    public function getVk()
    {
        return $this->vk;
    }

    /** @param string $vk */
    public function setVk($vk)
    {
        $this->vk = $vk;
    }

    /** @return string */
    public function getTelegram()
    {
        return $this->telegram;
    }

    /** @param string $telegram */
    public function setTelegram($telegram)
    {
        $this->telegram = $telegram;
    }

    /** @return string */
    public function getEmail()
    {
        return $this->email;
    }

    /** @param string $email */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /** @return array */
    public function getGoalsData()
    {
        switch ($this->getGoal()) {
            case self::GOAL_COORDINATOR:
                return [
                    'lecturer' => [$this->getCity()->getId()],
                    'volunteer' => [$this->getCity()->getId()],
                ];
            case self::GOAL_FOUNDER:
                return [
                    'other' => [],
                    'branch' => [],
                ];
            case self::GOAL_LECTURER:
                return [ 
                    'lecturer' => [$this->getCity()->getId()],
                ];
            case self::GOAL_VOLUNTEER:
                return [
                    'volunteer' => [$this->getCity()->getId()],
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

    /** @return bool */
    public function hasOwnPicture()
    {
        return $this->getPicture() && $this->getPicture() !== self::DEFAULT_PICTURE;
    }

    /**
     * @return bool
     */
    public function isGlobalContact()
    {
        return in_array($this->goal, self::GOALS_GLOBAL);
    }
}
