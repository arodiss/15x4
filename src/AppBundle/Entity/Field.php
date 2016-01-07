<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="field")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\FieldRepository")
 */
class Field
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
     * @ORM\Column(name="image_name", type="string", length=63, nullable=true)
     */
    protected $imageName;

    /**
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Lecture", mappedBy="field")
     */
    protected $lectures;

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

    /** @return string */
    public function getImageName()
    {
        return $this->imageName;
    }

    /** @param string $imageName */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /** @return string */
    public function getDescription()
    {
        return $this->description;
    }

    /** @param string $description */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @todo: real implementation here and in template
     * @return string
     */
    public function getDefaultImageName()
    {
        return "https://pp.vk.me/c633429/v633429147/ad03/yQN1nr6jgTo.jpg";
    }
}
