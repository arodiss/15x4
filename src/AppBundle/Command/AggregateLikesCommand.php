<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use AppBundle\Entity\User;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AggregateLikesCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:aggregate-likes");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Aggregating by lectures...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setLikesCount($this->getLikesCount($lecture));
            $lecture->setDislikesCount($this->getDislikesCount($lecture));
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\nAggregating by users...");
        $users = $this->getContainer()->get('repository.user')->findAll();
        $progress = new ProgressBar($output, count($users));
        foreach ($users as $user) {
            /** @var User $user */
            $user->setLikes($this->getLikes($user));
            $user->setDislikes($this->getDislikes($user));
            $this->getEm()->persist($user);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\n<info>Likes aggregated</info> ");
    }

    /**
     * @param Lecture $lecture
     * @return int
     */
    private function getLikesCount(Lecture $lecture)
    {
        return count($this->getContainer()->get('repository.lecture_reaction')->findBy([
            'lecture' => $lecture,
            'isLike' => true
        ]));
    }

    /**
     * @param Lecture $lecture
     * @return int
     */
    private function getDislikesCount(Lecture $lecture)
    {
        return count($this->getContainer()->get('repository.lecture_reaction')->findBy([
            'lecture' => $lecture,
            'isLike' => false
        ]));
    }

    /**
     * @param User $user
     * @return array
     */
    private function getLikes(User $user)
    {
        $qb = $this->getContainer()->get('repository.lecture_reaction')->createQueryBuilder('lr');

        return array_column(
            $qb
                ->andWhere($qb->expr()->eq('lr.user', $user->getId()))
                ->andWhere($qb->expr()->eq('lr.isLike', 1))
                ->innerJoin('lr.lecture', 'lecture')
                ->select('lecture.id')
                ->getQuery()
                ->getResult(),
            'id'
        );
    }

    /**
     * @param User $user
     * @return array
     */
    private function getDislikes(User $user)
    {
        $qb = $this->getContainer()->get('repository.lecture_reaction')->createQueryBuilder('lr');

        return array_column(
            $qb
                ->andWhere($qb->expr()->eq('lr.user', $user->getId()))
                ->andWhere($qb->expr()->eq('lr.isLike', 0))
                ->innerJoin('lr.lecture', 'lecture')
                ->select('lecture.id')
                ->getQuery()
                ->getResult(),
            'id'
        );
    }
}
