<?php

namespace App\Form;

use App\Document\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerName', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => ['placeholder' => 'Jean Dupont']
            ])
            ->add('rating', ChoiceType::class, [
                'label' => 'Note',
                'choices' => [
                    '5 - Excellent' => 5,
                    '4 - Très Bien' => 4,
                    '3 - Bien' => 3,
                    '2 - Moyen' => 2,
                    '1 - Mauvais' => 1,
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Votre Commentaire',
                'attr' => ['rows' => 5, 'placeholder' => 'Partagez votre expérience...']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer l\'avis',
                'attr' => ['class' => 'btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
