<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Titre du sujet',
            ])
            ->add('category', EntityType::class, [
                
                    'class' => Category::class,
                    'choice_label' => function(Category $category){
                        return $category->getTitle();
                    },
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Titre du sujet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
