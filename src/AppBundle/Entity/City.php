<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @var \AppBundle\Entity\Contact[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Contact", mappedBy="city")
     */
    protected $contacts;

    /**
     * @var \AppBundle\Entity\Announcement[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Announcement", mappedBy="city")
     */
    protected $announcements;

    /**
     * @ORM\Column(name="name", type="string", length=63, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @Assert\Type("float")
     * @Assert\Range(min = 0, max = 90)
     * @ORM\Column(name="latitude", type="float", nullable=false)
     */
    protected $latitude;

    /**
     * @Assert\Type("float")
     * @Assert\Range(min = -180, max = 180)
     * @ORM\Column(name="longitude", type="float", nullable=false)
     */
    protected $longitude;

    /**
     * @ORM\Column(name="ifttt_key", type="string", length=127, nullable=true)
     */
    protected $iftttKey;

    /**
     * @ORM\Column(name="timezone", type="string", length=63, nullable=false)
     */
    protected $timezone;

    /**
     * @ORM\Column(name="fb_link", type="string", length=63, nullable=true)
     */
    protected $fbLink;

    /**
     * @ORM\Column(name="tg_link", type="string", length=63, nullable=true)
     */
    protected $tgLink;

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

    /** @return float */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /** @param float $longitude */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /** @return float */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /** @param float $latitude */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /** @return string */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /** @param string $timezone */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /** @return string|null */
    public function getIftttKey()
    {
        return $this->iftttKey;
    }

    /** @param string $iftttKey */
    public function setIftttKey($iftttKey)
    {
        $this->iftttKey = $iftttKey;
    }

    /** @return string */
    public function getFbLink()
    {
        return $this->fbLink;
    }

    /** @param string $fbLink */
    public function setFbLink($fbLink)
    {
        $this->fbLink = $fbLink;
    }

    /** @return string */
    public function getTgLink()
    {
        return $this->tgLink;
    }

    /** @param string $tgLink */
    public function setTgLink($tgLink)
    {
        $this->tgLink = $tgLink;
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


    /** @return array|int[] */
    public function getEventIds()
    {
        $ids = [];
        foreach ($this->getEvents() as $event) {
            $ids[] = $event->getId();
        }

        return $ids;
    }

    /** @return Announcement */
    public function getAnnouncementTemplate()
    {
        $announcement = new Announcement();
        $announcement->setCity($this);
        if ($lastAnnouncement = $this->getLastAnnouncement()) {
            $announcement->setWhen($lastAnnouncement->getWhen());
            $announcement->setWhere($lastAnnouncement->getWhere());
            $announcement->setWhereMap($lastAnnouncement->getWhereMap());
            $announcement->setTotalTickets($lastAnnouncement->getTotalTickets());
        }

        return $announcement;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}
