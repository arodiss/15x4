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
     * @ORM\OneToOne(
     *  targetEntity="City",
     *  inversedBy="announcement"
     * )
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $city;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|\AppBundle\Entity\LectureAnnouncement[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\LectureAnnouncement", mappedBy="event", cascade={"persist"})
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
     * @ORM\Column(name="time", type="text", nullable=true)
     */
    protected $when;

    public function __construct()
    {
        $this->lectures = new \Doctrine\Common\Collections\ArrayCollection();
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
}
