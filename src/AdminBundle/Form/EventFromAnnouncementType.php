<?php

namespace AdminBundle\Form;

use AppBundle\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFromAnnouncementType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'city',
                EntityType::class,
                [
                    'label' => 'Город',
                    'class' => Entity\City::class,
                    'attr' => ['readonly' => true,]
                ]
            )
            ->add('date', DateType::class, ['label' => 'Дата', 'years' => range(2016, date('Y')) ])
            ->add('lectures', CollectionType::class, [
                'label' => 'Лекции',
                'prototype' => true,
                'by_reference' => false,
                'entry_type' => LectureType::class,
                'entry_options' => [
                    'label' => 'Лекция',
                    'is_standalone' => false,
                    'attr' => [ 'style' => 'background-color: #eee; padding-top: 7px; border: 1px dashed gray' ]
                ],
                'attr' => [ 'class' => 'lectures' ],

            ])
            ->add('save', SubmitType::class)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Entity\Event::class,
        ));
    }
}
