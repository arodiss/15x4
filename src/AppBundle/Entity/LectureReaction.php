<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LectureReactionRepository")
 * @ORM\Table(name="lecture_reaction", uniqueConstraints={
 *   @UniqueConstraint(columns={"user_id", "lecture_id"})
 * })
 */
class LectureReaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Lecture
     * @ORM\ManyToOne(targetEntity="Lecture")
     * @ORM\JoinColumn(name="lecture_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $lecture;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(name="is_like", type="boolean", nullable=false)
     */
    protected $isLike;

    /**
     * @param Lecture $lecture
     * @param User $user
     * @param $isLike
     */
    public function __construct(Lecture $lecture, User $user, $isLike)
    {
        $this->lecture = $lecture;
        $this->user = $user;
        $this->isLike = $isLike;
    }

    /** @return bool */
    public function isLike()
    {
        return $this->isLike;
    }
} 
