<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractCommand extends ContainerAwareCommand
{
    /** @return EntityManager */
    protected function getEm()
    {
        return $this->getContainer()->get("doctrine.orm.entity_manager");
    }
} 
