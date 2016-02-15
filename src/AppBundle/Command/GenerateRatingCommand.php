<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRatingCommand extends ContainerAwareCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:generate-rating");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Generating ratings...");

        foreach ($this->getContainer()->get('repository.lecture')->findAll() as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setRandomRating(rand(0, 1000));
            $this->getEm()->persist($lecture);
        }
        $this->getEm()->flush();

        $output->writeln("<info>Rating generated</info> ");
    }

    /** @return EntityManager */
    protected function getEm()
    {
        return $this->getContainer()->get("doctrine.orm.entity_manager");
    }
}
