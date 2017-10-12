<?php

namespace AdminBundle\Form;

use AppBundle\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    private $timezones = [
        'Europe/Berlin',
        'Europe/Kiev',
        'Europe/Minsk',
        'Europe/Chisinau',

        'Europe/Kaliningrad',
        'Europe/Moscow',
        'Europe/Samara',
        'Asia/Yekaterinburg',
        'Asia/Omsk',
        'Asia/Krasnoyarsk',
        'Asia/Irkutsk',
        'Asia/Yakutsk',
        'Asia/Vladivostok',
    ];

    /** {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Название'])
            ->add('latitude', NumberType::class, ['label' => 'Широта'])
            ->add('longitude', NumberType::class, ['label' => 'Долгота'])
            ->add('fbLink', TextType::class, ['label' => 'Ссылув Facebook', 'required' => false])
            ->add('tgLink', TextType::class, ['label' => 'Ссылка Telegram', 'required' => false])
            ->add(
                'iftttKey',
                TextType::class,
                [
                    'label' => 'IFTTT ключ',
                    'required' => false,
                    'attr' => ['placeholder' => '(не обязательно)'],
                ]
            )
            ->add(
                'timezone',
                ChoiceType::class,
                [
                    'label' => 'Часовой пояс',
                    'choices' => array_combine($this->timezones, $this->timezones)
                ]
            )
            ->add('save', SubmitType::class)
        ;
    }

    /** {@inheritdoc} */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => City::class,
        ));
    }
} 
