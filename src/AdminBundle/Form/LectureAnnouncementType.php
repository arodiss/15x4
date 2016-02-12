<?php

namespace AdminBundle\Form;

use AppBundle\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LectureAnnouncementType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Название'])
            ->add('teaser', TextareaType::class, ['label' => 'Тизер'])
            ->add(
                'field',
                EntityType::class,
                ['label' => 'Дисциплина', 'class' => Entity\Field::class, 'choice_label' => 'name']
            )
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
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Entity\LectureAnnouncement::class,
        ));
    }
}
