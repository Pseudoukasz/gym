<?php

namespace App\Form;

use App\Entity\Classes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'dateStart',
                DateTimeType::class,
                [
                    'date_widget' => 'single_text',
                    'attr' => ['class' => 'form_datetime'],
                    'placeholder' => [
                        'hour' => 'Hour',
                        'minute' => 'Minute',
                    ],
                ]
            )
            ->add(
                'dateEnd',
                DateTimeType::class,
                [
                    'date_widget' => 'single_text',
                    'attr' => ['class' => 'form_datetime'],
                    'placeholder' => [
                        'hour' => 'Hour',
                        'minute' => 'Minute',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'date_class' => Classes::class,
            ]
        );
    }
}
