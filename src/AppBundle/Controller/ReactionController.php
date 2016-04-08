<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use AppBundle\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ReactionController extends AbstractController
{
    /**
     * @Extra\Route("/react/", name="React")
     */
    public function reactAction(Request $request)
    {
        /** @var Entity\Lecture $lecture */
        $lecture = $this->getLectureRepository()->find($request->get('id'));
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
     * @Extra\Route("/fav/", name="Fav")
     */
    public function favAction(Request $request)
    {
        /** @var Entity\Lecture $lecture */
        $lecture = $this->getLectureRepository()->find($request->get('id'));

        $this->getUser()->favLecture($lecture);
        $this->getEm()->flush();

        return new Response();
    }

    /**
     * @Extra\Route("/unfav/", name="Unfav")
     */
    public function unfavAction(Request $request)
    {
        /** @var Entity\Lecture $lecture */
        $lecture = $this->getLectureRepository()->find($request->get('id'));

        $this->getUser()->unfavLecture($lecture);
        $this->getEm()->flush();

        return new Response();
    }
} 
