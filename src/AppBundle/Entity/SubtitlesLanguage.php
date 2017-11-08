<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="subtitles_language")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SubtitlesLanguageRepository")
 */
class SubtitlesLanguage
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=31, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="abbreviation", type="string", length=3, nullable=false, unique=true)

     */
    protected $abbreviation;

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

    /** @return string */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /** @param string $abbreviation */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }
}
