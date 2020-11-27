<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Rooms;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'date_start',
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
                'date_end',
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
                'room',
                EntityType::class,[
                'class'=>Rooms::class,
                'choice_label'=>'name',
            ])
            ->add('submit', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-danger float-left',
                    'id' => 'submit'
                ]]);

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
