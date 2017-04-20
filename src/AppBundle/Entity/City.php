<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CityRepository")
 * @UniqueEntity("name")
 */
class City
{
    const DORMANT_THRESHOLD = "-6 month";

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Event[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Event", mappedBy="city")
     */
    protected $events;

    /**
     * @var \AppBundle\Entity\Announcement[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Announcement", mappedBy="city")
     */
    protected $announcements;

    /**
     * @ORM\Column(name="name", type="string", length=63, nullable=false, unique=true)
     */
    protected $name;

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName();
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
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

    /** @return Announcement[] */
    public function getAnnouncements()
    {
        return $this->announcements;
    }

    /** @return Event[] */
    public function getEvents()
    {
        return $this->events;
    }

    /** @return Announcement|null */
    public function getNextAnnouncement()
    {
        foreach ($this->getAnnouncements() as $announcement) {
            if ($announcement->getDate() >= (new \DateTime)->modify('today midnight')) {
                return $announcement;
            }
        }

        return null;
    }

    /** @return bool */
    public function hasValidAnnouncement()
    {
        return (bool) $this->getNextAnnouncement();
    }

    /** @return bool */
    public function hasVeryOutdatedAnnouncements()
    {
        foreach ($this->getAnnouncements() as $announcement) {
            if ($announcement->getDate() <= (new \DateTime)->modify('-1 month')) {
                return true;
            }
        }
        
        return false;
    }

    /** @return Announcement|null */
    public function getLastAnnouncement()
    {
        /** @var Announcement|null $current */
        $current = null;
        foreach ($this->getAnnouncements() as $announcement) {
            if ($announcement->getDate() < (new \DateTime)->modify('today midnight')) {
                if ($current === null || $announcement->getDate() > $current->getDate()) {
                    $current = $announcement;
                }
            }
        }

        return $current;
    }

    /** @return bool */
    public function isDormant()
    {
        $lastAnnouncement = $this->getLastAnnouncement();
        if ($lastAnnouncement && $lastAnnouncement->getDate() > (new \DateTime(self::DORMANT_THRESHOLD))) {
            return false;
        }
        foreach ($this->getEvents() as $event) {
            if ($event->getDate() > (new \DateTime(self::DORMANT_THRESHOLD))) {
                return false;
            }
        }

        return true;
    }
}
