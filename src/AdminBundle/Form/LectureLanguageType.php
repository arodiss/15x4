<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LectureLanguageType extends ChoiceType
{
    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'label' => 'Язык',
            'choice_translation_domain' => false,
            'choices' => [
                'Русский' => 'ru',
                'English' => 'en',
                'Українська' => 'uk',
                'Deutsch' => 'de',
                'Română' => 'ro',
            ]
        ]);
    }
}
