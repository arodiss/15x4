<?php

namespace AppBundle\Translations;

use JMS\TranslationBundle\Translation\ConfigFactory;
use JMS\TranslationBundle\Translation\Updater as JmsUpdater;

class Updater
{
    /** @var ConfigFactory */
    private $configFactory;

    /** @var JmsUpdater */
    private $jmsUpdater;

    /** @var string */
    private $cacheDir;

    /** @var array */
    private $locales = ['uk', 'de', 'en'];

    /**
     * @param ConfigFactory $configFactory
     * @param JmsUpdater $jmsUpdater
     * @param string $cacheDir
     */
    public function __construct(ConfigFactory $configFactory, JmsUpdater $jmsUpdater, $cacheDir)
    {
        $this->jmsUpdater = $jmsUpdater;
        $this->configFactory = $configFactory;
        $this->cacheDir = realpath($cacheDir . '/../');
    }

    public function update()
    {
        foreach ($this->locales as $locale) {
            $this->jmsUpdater->process($this
                ->configFactory
                ->getConfig('app', $locale)
            );
        }

        shell_exec("rm -rf $this->cacheDir/*");
    }
}
