<?php

namespace AdminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity;

class ContactType extends AbstractType
{
    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Type\TextType::class, ['label' => 'Имя'])
            ->add('goal', Type\ChoiceType::class, [
                'label' => 'Роль',
                'choices' => array_combine(Entity\Contact::getAllGoals(), Entity\Contact::getAllGoals())
            ])
            ->add(
                'city',
                EntityType::class,
                ['label' => 'Город', 'class' => Entity\City::class, 'choice_label' => 'name']
            )
            ->add('picture', ContactPictureType::class, ['label' => 'Фото'])
            ->add('vk', Type\TextType::class, [
                'required' => false,
                'label' => 'VK идентификатор',
                'attr' => [
                    'placeholder' => '(не обязательно)'
                ]
            ])
            ->add('fb', Type\TextType::class, [
                'required' => false,
                'label' => 'FB идентификатор',
                'attr' => [
                    'placeholder' => '(не обязательно)'
                ]
            ])
            ->add('telegram', Type\TextType::class, [
                'required' => false,
                'label' => 'Telegram идентификатор',
                'attr' => [
                    'placeholder' => '(не обязательно)'
                ]
            ])
            ->add('email', Type\TextType::class, [
                'required' => false,
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => '(не обязательно)'
                ]
            ])
            ->add('save', Type\SubmitType::class)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => false,
            'data_class' => Entity\Contact::class,
        ));
    }
} 
