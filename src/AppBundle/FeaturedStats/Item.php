<?php

namespace AppBundle\FeaturedStats;

class Item
{
    /** @var string */
    private $name;
    
    /** @var int */
    private $totalVotes = 0;

    /** @var int */
    private $upVotes = 0;

    /** @param string $name */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /** @param $isUpVote bool */
    public function vote($isUpVote)
    {
        $this->totalVotes++;
        if ($isUpVote) {
            $this->upVotes++;
        }
    }

    /** @return float */
    public function getScore()
    {
        return 100 * $this->upVotes / $this->totalVotes;
    }

    /** @return int */
    public function getTotalVotes()
    {
        return $this->totalVotes;
    }

    /** @return int */
    public function getUpVotes()
    {
        return $this->upVotes;
    }
}
