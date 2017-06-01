<?php

namespace AppBundle\Command;

use AppBundle\Entity\City;
use AppBundle\Entity\Contact;
use AppBundle\Entity\ContactOld;
use AppBundle\Twig\ContactsExtension;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConvertContactsCommand extends AbstractCommand
{
    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:convert-contacts");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Converting contacts...");
        $contacts = (new ContactsExtension())->getContacts();
        foreach ($contacts as $contact) {
            /** @var ContactOld $contact */
            $entity = new Contact();
            $entity->setName($contact->getName());
            $entity->setGoal($contact->getGoal());
            $entity->setPicture($contact->getPicture());
            $entity->setEmail($contact->getEmail());
            $entity->setVk($contact->getVk());
            $entity->setFb($contact->getFb());
            $entity->setCity($this->getCity($contact));
            $this->getEm()->persist($entity);
        }
        $this->getEm()->flush();
        $output->writeln("Done!");
    }

    /**
     * @param ContactOld $contact
     * @return City
     */
    protected function getCity(ContactOld $contact)
    {
        $entity = $this->getContainer()->get('repository.city')->findOneByName(
            (new ContactsExtension())->getContactCity($contact->getCity())
        );

        if (false === $entity instanceof City) {
            throw new \RuntimeException(sprintf(
                'Cannot convert city `%s`, #%s',
                (new ContactsExtension())->getContactCity($contact->getCity()),
                $contact->getCity()
            ));
        }

        return $entity;
    }
}
