<?php

namespace App\Form;

use App\Entity\Meal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MealFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('foodTime')
            ->add('foodName')
            ->add('calories')
            ->add('grams', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'inputmode' => 'decimal',
                    'pattern' => '[0-9]*[.,]?[0-9]+',
                    'placeholder' => '0.00',
                ],
            ])
            ->add('carbs', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'inputmode' => 'decimal',
                    'pattern' => '[0-9]*[.,]?[0-9]+',
                    'placeholder' => '0.00',
                ],
            ])
            ->add('fat', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'inputmode' => 'decimal',
                    'pattern' => '[0-9]*[.,]?[0-9]+',
                    'placeholder' => '0.00',
                ],
            ])
            ->add('protein', NumberType::class, [
                'scale' => 2,
                'attr' => [
                    'inputmode' => 'decimal',
                    'pattern' => '[0-9]*[.,]?[0-9]+',
                    'placeholder' => '0.00',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
