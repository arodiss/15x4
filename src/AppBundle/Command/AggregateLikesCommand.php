<?php

namespace AppBundle\Command;

use AppBundle\Entity\Lecture;
use AppBundle\Entity\User;
use AppBundle\Entity\CommentThread;
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
        $output->writeln("Aggregating comments...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setCommentsCount($this->getCommentsCount($lecture));
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\nAggregating likes by lectures...");
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

        $output->writeln("\nAggregating likes by users...");
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

        $output->writeln("\nAggregating favs by lectures...");
        $lectures = $this->getContainer()->get('repository.lecture')->findAll();
        $progress = new ProgressBar($output, count($lectures));
        foreach ($lectures as $lecture) {
            /** @var Lecture $lecture */
            $lecture->setFavsCount(count($lecture->getUsersFavorited()));
            $this->getEm()->persist($lecture);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\nAggregating favs by users...");
        $users = $this->getContainer()->get('repository.user')->findAll();
        $progress = new ProgressBar($output, count($users));
        foreach ($users as $user) {
            /** @var User $user */
            $user->setFavoriteLectureIds($this->getFavoriteLectureIds($user));
            $this->getEm()->persist($user);
            $progress->advance();
        }
        $progress->finish();
        $this->getEm()->flush();

        $output->writeln("\n<info>Reactions aggregated</info> ");
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
     * @param Lecture $lecture
     * @return int
     */
    private function getCommentsCount(Lecture $lecture)
    {
        /** @var CommentThread|null $thread */
        $thread = $this->getContainer()->get('repository.comment_thread')->find($lecture->getId());

        return $thread ? $thread->getNumComments() : 0;
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

    /**
     * @param User $user
     * @return array
     */
    private function getFavoriteLectureIds(User $user)
    {
        $favorites = [];
        foreach ($user->getFavoriteLectures() as $lecture) {
            $favorites[] = $lecture->getId();
        }

        return $favorites;
    }
}
