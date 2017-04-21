<?php

namespace AppBundle\FeaturedStats;

use AppBundle\Entity\Lecture;
use AppBundle\Entity\Repository\LectureRepository;

class Aggregator
{
    /** @var LectureRepository */
    private $lectureRepository;

    /** @var Item */
    private $all;

    /** @param LectureRepository $lectureRepository */
    public function __construct(LectureRepository $lectureRepository)
    {
        $this->lectureRepository = $lectureRepository;
    }

    /** @return array */
    public function getStats()
    {
        $fields = new NormzalizedContainer($this);
        $cities = new NormzalizedContainer($this);
        $speakers = new Container($this);
        $languages = new NormzalizedContainer($this);
        $this->all = new Item('all');
        foreach (
            $this
                ->lectureRepository
                ->createQueryBuilder('l')
                ->leftJoin('l.lecturer', 'll')
                ->leftJoin('l.field', 'f')
                ->leftJoin('l.event', 'e')
                ->leftJoin('e.city', 'c')
                ->select(['l', 'll', 'f', 'e', 'c'])
                ->getQuery()
                ->getResult()
            as $lecture
        ) {
            /** @var Lecture $lecture */
            $fields->addVote($lecture->getField()->getName(), $lecture->getIsFeatured());
            $cities->addVote($lecture->getCity()->getName(), $lecture->getIsFeatured());
            $languages->addVote($lecture->getLanguage(), $lecture->getIsFeatured());
            $speakers->addVote($lecture->getLecturer()->getName(), $lecture->getIsFeatured());
            $this->all->vote($lecture->getIsFeatured());
        }

        return [
            'fields' => $fields,
            'cities' => $cities,
            'speakers' => $speakers,
            'languages' => $languages,
            'avgScore' => $this->all->getScore() * 1.3,
            'highScore' => $this->all->getScore() * 1.3,
            'lowScore' => $this->all->getScore() * 0.7,
        ];
    }

    /** @return float */
    public function getScore()
    {
        return $this->all->getScore();
    }
}
