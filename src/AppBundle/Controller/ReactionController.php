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
        $isLike = $request->get('reaction') === 'like';
        $previousReaction = $this->getLectureReactionRepository()->findBy([
            'lecture' => $lecture,
            'user' => $this->getUser()
        ]);
        if (count($previousReaction) === 1) {
            $this->getEm()->remove($previousReaction[0]);
            $this->getEm()->flush();
            if ($isLike) {
                $lecture->setDislikesCount($lecture->getDislikesCount() - 1);
            } else {
                $lecture->setLikesCount($lecture->getLikesCount() - 1);
            }
        }

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
} 
