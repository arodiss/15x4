<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use AppBundle\Entity\Tag;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRatingCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:generate-rating");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Generating rating for lectures...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setRandomRating(rand(0, 1000));
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\nGenerating rating for tags...");
        $tags = $this->getContainer()->get('repository.tag')->findAll();
        $progress = new ProgressBar($output, count($tags));
        foreach ($tags as $tag) {
            /** @var Tag $tag */
            $tag->setRandomRating(rand(0, 1000));
            $this->getEm()->persist($tag);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\n<info>Ratings generated</info> ");
    }
}
