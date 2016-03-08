<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateLikesCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:calculate-likes");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Calculating lecture likes...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setYoutubeLikesCount($this->getLikesCount($lecture));
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\n<info>Likes calculated</info> ");
    }

    /**
     * @param Lecture $lecture
     * @return int
     */
    private function getLikesCount(Lecture $lecture)
    {
        try {
            $info = (array)$this->getContainer()->get('youtube')->getVideoInfo($lecture->getVideoId(), ['statistics']);
        } catch (\Exception $e) {
            return 0;
        }
        if (false === isset($info['statistics'])
            || false === is_object($info['statistics'])
            || false === property_exists($info['statistics'], 'likeCount')
        ) {
            return 0;
        }

        return $info['statistics']->likeCount;
    }
}
