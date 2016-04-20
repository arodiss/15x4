<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class CommentThread extends BaseThread
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;
}
