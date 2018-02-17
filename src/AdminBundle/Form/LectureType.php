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
            ->add(
                'video_url',
                TextType::class,
                [
                    'label' => 'Видео лекции',
                    'attr' => [
                        'help' => 'youtube.com/watch?v=123123, youtu.be/123123, youtube.com/embed/123123',
                    ]

                ]
            )
            ->add('discussion_video_url', TextType::class, [
                'label' => 'Видео обсуждения',
                'required' => false,
                'attr' => [ 'placeholder' => '(не обязательно)' ],
            ])
            ->add('teaser', TextareaType::class, ['label' => 'Тизер'])
            ->add(
                'field',
                EntityType::class,
                [
                    'label' => 'Категория',
                    'class' => Entity\Field::class,
                    'choice_label' => 'name',
                    'choice_translation_domain' => true
                ]
            )
            ->add('language', LectureLanguageType::class)
            ->add(
                'lecturer',
                EntityType::class,
                [
                    'label' => 'Лектор',
                    'class' => Entity\Lecturer::class,
                    'choice_label' => 'name',
                    'required' => false,
                    'attr' => ['class' => 'selectizable'],
                    'query_builder'=> function (Entity\Repository\LecturerRepository $repo) {
                        return $repo
                            ->createQueryBuilder('lecturer')
                            ->orderBy('lecturer.name', 'ASC');
                    }
                ]
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
                    'attr' => ['class' => 'selectizable'],
                    'query_builder'=> function (Entity\Repository\TagRepository $repo) {
                        return $repo
                            ->createQueryBuilder('tag')
                            ->orderBy('tag.name', 'ASC');
                    }
                ]
            )
            ->add(
                'subtitlesLanguages',
                EntityType::class,
                [
                    'label' => 'Субтитры',
                    'class' => Entity\SubtitlesLanguage::class,
                    'choice_label' => 'abbreviation',
                    'multiple' => true,
                    'required' => false,
                    'attr' => ['class' => 'selectizable'],
                ]
            );


            if ($options['is_standalone']) {
                if (false === $options['skip_event']) {
                    $builder
                        ->add(
                            'event',
                            EntityType::class,
                            [
                                'label' => 'Ивент',
                                'class' => Entity\Event::class,
                                'group_by' => 'city',
                                'required' => false,
                                'attr' => ['class' => 'selectizable'],
                                'choice_label' => function (Event $event) {
                                    return sprintf(
                                        "%s, %s",
                                        $event->getCity()->getName(),
                                        $event->getDate()->format("d.m.Y")
                                    );
                                }
                            ]
                        );
                }
                $builder->add('save', SubmitType::class);
            }
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Entity\Lecture::class,
            'is_standalone' => true,
            'skip_event' => false
        ));
    }
} 
