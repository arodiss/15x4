<?php

namespace AppBundle\Translations;

use AppBundle\Entity;
use AppBundle\Entity\Repository;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Model\MessageCatalogue;
use JMS\TranslationBundle\Translation\ExtractorInterface;

class Extractor implements ExtractorInterface
{
    /** @var MessageCatalogue */
    private $catalogue;

    /** @var Repository\CityRepository */
    private $cityRepository;

    /** @var Repository\FieldRepository */
    private $fieldRepository;

    /** @var Repository\TagRepository */
    private $tagRepository;

    /**
     * @param Repository\CityRepository $cityRepository
     * @param Repository\FieldRepository $fieldRepository
     * @param Repository\TagRepository $tagRepository
     */
    public function __construct(
        Repository\CityRepository $cityRepository,
        Repository\FieldRepository $fieldRepository,
        Repository\TagRepository $tagRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->fieldRepository = $fieldRepository;
        $this->tagRepository = $tagRepository;
        $this->catalogue = new MessageCatalogue();
    }

    /** @return MessageCatalogue */
    public function extract()
    {
        foreach ($this->fieldRepository->findAll() as $field) {
            /** @var Entity\Field $field */
            $this->add($field->getName());
        }
        foreach ($this->cityRepository->findAll() as $city) {
            /** @var Entity\City $city */
            $this->add($city->getName());
        }
        foreach ($this->tagRepository->findAllWhichHas2PlusLectures() as $tag) {
            /** @var Entity\Tag $city */
            $this->add($tag->getName());
        }
        foreach (Entity\RandomScientist::all() as $scientist) {
            $this->add($scientist);
        }
        foreach (Entity\Contact::getAllGoals() as $goal) {
            $this->add($goal);
        }

        return $this->catalogue;
    }

    /** @param string $message */
    private function add($message)
    {
        $message = new Message($message);
        $this->catalogue->set($message);
    }
}
