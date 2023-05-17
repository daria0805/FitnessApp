<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeleteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('confirm', SubmitType::class, [
            'label' => 'Delete',
            // 'attr' => ['class' => 'btn btn-danger'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // $resolver->setDefaults([
        //     'method' => 'DELETE',
        //     'csrf_protection' => true,
        // ]);
        $resolver->setDefaults([
            'mapped' => false,
        ]);
    }
}
