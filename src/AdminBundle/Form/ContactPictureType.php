<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactPictureType extends ChoiceType
{
    /** @var string */
    private $folder;

    /** @param string $kernelRootDir */
    public function setKernelRootDir($kernelRootDir)
    {
        $this->folder = realpath($kernelRootDir . '/../src/AppBundle/Resources/public/images/contacts');
    }
    
    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'placeholder' => 'Не указано',
            'required' => false,
            'translation_domain' => false,
            'choice_translation_domain' => false,
            'choices' => array_combine($this->getPossiblePictures(), $this->getPossiblePictures()),
        ]);
    }

    private function getPossiblePictures()
    {
        $pictures = scandir($this->folder);
        unset($pictures[array_search('.', $pictures)]);
        unset($pictures[array_search('..', $pictures)]);

        return $pictures;
    }
}
