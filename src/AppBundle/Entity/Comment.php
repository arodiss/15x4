<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use FOS\CommentBundle\Model\SignedCommentInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Comment extends BaseComment implements SignedCommentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CommentThread
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CommentThread")
     */
    protected $thread;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $author;

    /** @param UserInterface $author */
    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    /** @return User|UserInterface */
    public function getAuthor()
    {
        return $this->author;
    }

    /** @return string */
    public function getAuthorName()
    {
        if (null === $this->getAuthor()) {
            return 'Anonymous';
        }

        return $this->getAuthor()->getDisplayableName();
    }
}
