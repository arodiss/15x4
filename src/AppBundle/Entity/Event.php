<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \AppBundle\Entity\Lecture[]
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Lecture", mappedBy="event")
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
}

