<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\TagRepository")
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
     * @ORM\ManyToMany(targetEntity="Lecture")
     * @ORM\JoinTable(name="tag_lecture",
     *     joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="lecture_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $lectures;

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
}
