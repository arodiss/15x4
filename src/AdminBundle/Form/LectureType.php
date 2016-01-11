<?php

namespace AdminBundle\Form;

use AppBundle\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity;

class LectureType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Название'])
            ->add('video_id', TextType::class, ['label' => 'Идентификатор видео лекции'])
            ->add('discussion_video_id', TextType::class, ['label' => 'Идентификатор видео обсуждения'])
            ->add('teaser', TextareaType::class, ['label' => 'Тизер'])
            ->add(
                'field',
                EntityType::class,
                ['label' => 'Дисциплина', 'class' => Entity\Field::class, 'choice_label' => 'name']
            )
            ->add(
                'lecturer',
                EntityType::class,
                ['label' => 'Лектор', 'class' => Entity\Lecturer::class, 'choice_label' => 'name']
            )
            ->add(
                'event',
                EntityType::class,
                ['label' => 'Ивент', 'class' => Entity\Event::class, 'choice_label' => function (Event $event) {
                    return sprintf(
                        "%s, %s",
                        $event->getCity()->getName(),
                        $event->getDate()->format("d.m.Y")
                    );
                }]
            )
            ->add(
                'tags',
                EntityType::class,
                [
                    'label' => 'Теги',
                    'class' => Entity\Tag::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                ]
            )
            ->add('save', SubmitType::class)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Entity\Lecture::class,
        ));
    }
} 
