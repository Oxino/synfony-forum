<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre prénom'
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre nom'
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => "Votre nom d'utilisateur"
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre adresse'
            ])
            ->add('zip_code', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre code postale'
            ])
            ->add('phone_number', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'label' => 'Votre numéro de téléphone'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
