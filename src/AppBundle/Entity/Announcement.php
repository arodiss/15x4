<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="announcement")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AnnouncementRepository")
 */
class Announcement
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var City
     * @ORM\ManyToOne(
     *  targetEntity="City",
     *  inversedBy="announcements"
     * )
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $city;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\LectureAnnouncement[]
     * @ORM\OneToMany(
     *  targetEntity="\AppBundle\Entity\LectureAnnouncement",
     *  mappedBy="event",
     *  cascade={"persist"},
     *  orphanRemoval=true
     * )
     * @Assert\Valid()
     */
    protected $lectures;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    protected $date;

    /**
     * @ORM\Column(name="place", type="text", nullable=true)
     */
    protected $where;

    /**
     * @ORM\Column(name="place_map", type="text", nullable=true)
     */
    protected $whereMap;

    /**
     * @ORM\Column(name="time", type="text", nullable=true)
     */
    protected $when;

    /**
     * @var integer
     * @ORM\Column(name="total_tickets", type="integer", nullable=true)
     */
    protected $totalTickets = 0;

    /**
     * @var array
     * @ORM\Column(name="tickets_booked", type="json_array", nullable=true)
     */
    protected $ticketsBooked = [];

    public function __construct()
    {
        $this->lectures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /** @return int */
    public function getId()
    {
        return $this->id;
    }

    /** @return \DateTime */
    public function getDate()
    {
        return $this->date;
    }

    /** @param \DateTime $date */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @param City $city
     * @return self
     */
    public function setCity(City $city)
    {
        $this->city = $city;

        return $this;
    }

    /** @return City */
    public function getCity()
    {
        return $this->city;
    }

    /** @return string */
    public function getWhen()
    {
        return $this->when;
    }

    /** @param string $when */
    public function setWhen($when)
    {
        $this->when = $when;
    }

    /** @return string */
    public function getWhere()
    {
        return $this->where;
    }

    /** @param string $where */
    public function setWhere($where)
    {
        $this->where = $where;
    }

    /** @return string */
    public function getWhereMap()
    {
        return $this->whereMap ?: $this->getWhere();
    }

    /** @param string $whereMap */
    public function setWhereMap($whereMap)
    {
        $this->whereMap = $whereMap;
    }

    /** @param LectureAnnouncement $lecture */
    public function addLecture(LectureAnnouncement $lecture)
    {
        if (false == $this->lectures->contains($lecture)) {
            $this->lectures->add($lecture);
        }
        $lecture->setEvent($this);
    }

    /** @param LectureAnnouncement $lecture */
    public function removeLecture(LectureAnnouncement $lecture)
    {
        $this->lectures->removeElement($lecture);
    }

    /** @return LectureAnnouncement[]|\Doctrine\Common\Collections\ArrayCollection */
    public function getLectures()
    {
        return $this->lectures;
    }


    /**
     * @param string $name
     * @param int $ticketsToBook
     */
    public function addTicketsBooking($name, $ticketsToBook = 1)
    {
        while ($ticketsToBook > 0) {
            $this->ticketsBooked[] = $name;
            $ticketsToBook--;
        }
    }

    /** @return array */
    public function getTicketsBookedGrouped()
    {
        $grouped = array_count_values($this->ticketsBooked);
        ksort($grouped);

        return $grouped;
    }

    /** @return bool */
    public function isRegisterable()
    {
        return (bool)$this->getTotalTickets();
    }

    /** @return bool */
    public function hasFreeTickets()
    {
        return $this->totalTickets > count($this->ticketsBooked);
    }

    /** @param int $totalTickets */
    public function setTotalTickets($totalTickets)
    {
        $this->totalTickets = $totalTickets;
    }

    /** @return int */
    public function getTotalTickets()
    {
        return $this->totalTickets;
    }
}
