<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ReactionController extends AbstractController
{
    /**
     * @Extra\Route("/react/{id}", name="React")
     * @Extra\ParamConverter()
     */
    public function reactAction(Entity\Lecture $lecture, Request $request)
    {
        $this->removeLectureReaction($lecture);

        $isLike = $request->get('reaction') === 'like';
        if ($isLike) {
            $this->getUser()->likeLecture($lecture);
        } else {
            $this->getUser()->dislikeLecture($lecture);
        }

        $reaction = new Entity\LectureReaction($lecture, $this->getUser(), $isLike);
        $this->getEm()->persist($reaction);
        $this->getEm()->flush();

        return new Response();
    }

    /**
     * @Extra\Route("/unreact/{id}", name="Unreact")
     * @Extra\ParamConverter()
     */
    public function removeReactionAction(Entity\Lecture $lecture)
    {
        $this->removeLectureReaction($lecture);

        return new Response();
    }

    /**
     * @Extra\Route("/fav/{id}", name="Fav")
     * @Extra\ParamConverter()
     */
    public function favAction(Entity\Lecture $lecture)
    {
        $this->getUser()->favLecture($lecture);
        $this->getEm()->flush();

        return new Response();
    }

    /**
     * @Extra\Route("/unfav/{id}", name="Unfav")
     * @Extra\ParamConverter()
     */
    public function unfavAction(Entity\Lecture $lecture)
    {
        $this->getUser()->unfavLecture($lecture);
        $this->getEm()->flush();

        return new Response();
    }

    /** @param Entity\Lecture $lecture */
    protected function removeLectureReaction(Entity\Lecture $lecture)
    {
        $previousReaction = $this->getLectureReactionRepository()->findBy([
            'lecture' => $lecture,
            'user' => $this->getUser()
        ]);
        if (count($previousReaction) === 1) {
            /** @var Entity\LectureReaction $previousReaction */
            $previousReaction = $previousReaction[0];
            $this->getEm()->remove($previousReaction);
            $this->getUser()->removeLectureReaction($lecture);
            if ($previousReaction->isLike()) {
                $lecture->setLikesCount($lecture->getLikesCount() - 1);
            } else {
                $lecture->setDislikesCount($lecture->getDislikesCount() - 1);
            }
        }
        $this->getEm()->flush();
    }
} 
