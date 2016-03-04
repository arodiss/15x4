<?php

namespace AppBundle\Twig;

use Doctrine\ORM\PersistentCollection;

class UnixPipesExtension extends \Twig_Extension
{
    /** {@inheritDoc} */
    public function getName()
    {
        return 'unix_pipes';
    }
    /** {@inheritDoc} */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('head', [$this, 'head']),
        ];
    }
    /**
     * @param array $incoming
     * @param $headSize
     * @return mixed
     */
    public function head($incoming, $headSize)
    {
        if ($incoming instanceof PersistentCollection) {
            return $incoming->slice(0, $headSize);
        }
        return array_chunk($incoming, $headSize)[0];
    }
}
