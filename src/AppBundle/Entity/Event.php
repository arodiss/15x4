<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \AppBundle\Entity\Lecture[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Lecture", mappedBy="event", cascade={"persist"})
     */
    protected $lectures;

    /**
     * @var City
     * @ORM\ManyToOne(
     *  targetEntity="City",
     *  inversedBy="events"
     * )
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $city;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    protected $date;
    
    public function __construct()
    {
        $this->created = new \DateTime();
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

    /** @return City */
    public function getCity()
    {
        return $this->city;
    }

    /** @param City $city */
    public function setCity(City $city)
    {
        $this->city = $city;
    }

    /** @return Lecture[] */
    public function getLectures()
    {
        return $this->lectures;
    }

    /** @param $lectures */
    public function setLectures($lectures)
    {
        $this->lectures = $lectures;
    }

    /**
     * @param Announcement $announcement
     * @return self
     */
    public static function fromAnnouncement(Announcement $announcement)
    {
        $self = new self;
        $self->setCity($announcement->getCity());
        $self->setDate($announcement->getDate());
        $lectures = new ArrayCollection();
        foreach ($announcement->getLectures() as $lectureAnnouncement) {
            $lecture = Lecture::fromAnnouncement($lectureAnnouncement);
            $lecture->setEvent($self);
            $lectures->add($lecture);
        }
        $self->lectures = $lectures;

        return $self;
    }

    /** @return \DateTime */
    public function getCreated()
    {
        return $this->created;
    }
}
