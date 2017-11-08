<?php

namespace AppBundle\Command;

use AppBundle\Entity\SubtitlesLanguage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadSubtitlesLanguagesCommand extends AbstractCommand
{
    /** @var array */
    protected $config = [
        [
            'name' => 'Английский',
            'abbreviation' => 'EN',
        ],
        [
            'name' => 'Русский',
            'abbreviation' => 'RU',
        ],
        [
            'name' => 'Украинский',
            'abbreviation' => 'UA',
        ],
        [
            'name' => 'Немецкий',
            'abbreviation' => 'DE',
        ],
    ];

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:load-subs-langs");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Loading subtitles languages...");

        foreach ($this->config as $fieldConfig) {
            $field = new SubtitlesLanguage();
            $field->setName($fieldConfig['name']);
            $field->setAbbreviation($fieldConfig['abbreviation']);
            $this->getEm()->persist($field);
        }
        $this->getEm()->flush();

        $output->writeln("<info>Subtitles languages loaded</info> ");
    }
}
