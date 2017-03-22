<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTranslationsCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:i18n-update");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Updating translations...");
        $this->getContainer()->get('15x4.i18n_updater')->update();
        $output->writeln("Translations updated");
    }
}
