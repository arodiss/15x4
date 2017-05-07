<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion("<error>WARNING</error>\nAre you sure your DB is up-to-date? If not, some existing translations may be deleted\n(y/n)", false);
        if (false === $helper->ask($input, $output, $question)) {
            $output->writeln("Update canceled");
            return;
        }

        $output->writeln("Updating translations (invalid translation will be pruned)...");
        $this->getContainer()->get('15x4.i18n_updater')->update();
        $output->writeln("Translations updated");
    }
}
