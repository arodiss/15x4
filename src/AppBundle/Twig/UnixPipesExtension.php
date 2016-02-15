<?php

namespace AppBundle\Twig;

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
    public function head(array $incoming, $headSize)
    {
        return array_chunk($incoming, $headSize)[0];
    }
}
