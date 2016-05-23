<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TagRepository")
 * @UniqueEntity("name")
 */
class Tag
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=63, nullable=false, unique=true)

     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Lecture", mappedBy="tags")
     */
    protected $lectures;

    /**
     * @ORM\Column(name="random_rating", type="integer", nullable=false)
     */
    protected $randomRating = 500;

    /** {@inheritdoc} */
    public function __toString()
    {
        return "#" . $this->getName();
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

    /** @return int */
    public function getRandomRating()
    {
        return $this->randomRating;
    }

    /** @param int $randomRating */
    public function setRandomRating($randomRating)
    {
        $this->randomRating = $randomRating;
    }
}
