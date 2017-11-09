<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillLectureCreatedCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:fill-created");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Filling lectures `created`...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setCreated($lecture->getEvent()->getCreated());
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("<info>Filled</info> ");
    }
}
