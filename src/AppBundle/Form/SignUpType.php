<?php

namespace AppBundle\Form;

use AppBundle\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SignUpType extends AbstractType
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @param TokenStorageInterface $tokenStorage */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'announcement',
                EntityType::class,
                [
                    'label' => 'Встреча',
                    'class' => Entity\Announcement::class,
                    'attr' => [
                        'readonly' => true,
                    ]
                ]
            )
            ->add(
                'extra',
                IntegerType::class,
                [
                    'label' => 'Сколько вам нужно дополнительных билетов?',
                    'data' => 0,
                    'required' => false,
                    'attr' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ]
                ]
            )
            ->add(
                'contact',
                TextType::class,
                [
                    'label' => 'Как с вами связаться?',
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'Почта, ссылка на социальные сети, номер телефона...',
                    ]
                ]
            )

        ;

        if ($this->tokenStorage->getToken()
            && $this->tokenStorage->getToken()->getUser() instanceof Entity\User
        ) {
            $builder->add(
                'name',
                TextType::class,
                [
                    'label' => 'Под каким именем вас записать?',
                    'data' => $this->tokenStorage->getToken()->getUser()->getDisplayableName()
                ]
            );
        } else {
            $builder->add(
                'name',
                TextType::class,
                [
                    'label' => 'Меня зовут',
                    'attr' => [
                        'placeholder' => Entity\RandomScientist::name()
                    ]
                ]
            );
        }
        ;
    }
}
