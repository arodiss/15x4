<?php

namespace AppBundle\FeaturedStats;

class Container
{
    /** @var array|Item[]  */
    protected $items = [];

    /** @var Aggregator */
    protected $aggregator;

    /** @param Aggregator $aggregator */
    public function __construct(Aggregator $aggregator)
    {
        $this->aggregator = $aggregator;
    }

    /**
     * @param $name string
     * @param $isUpvote bool
     */
    public function addVote($name, $isUpvote)
    {
        if (false === isset($this->items[$name])) {
            $this->items[$name] = new Item($name);
        }
        $this->items[$name]->vote($isUpvote);
    }

    /**
     * Return list of items, sorted from most upvoted downwards
     * @return Item[]
     */
    public function getItems()
    {
        usort($this->items, function (Item $item1, Item $item2) {
            return $item2->getUpVotes() - $item1->getUpVotes();
        });

        return array_filter($this->items, function (Item $item) {
            return $item->getUpVotes() > 0;
        });
    }
}
