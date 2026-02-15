<?php

namespace App\Form;

use App\Entity\QuoteRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contactName', TextType::class, [
                'label' => 'Votre Nom',
                'required' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'Jean Dupont']
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Votre Email',
                'required' => false,
                'attr' => ['class' => 'form-input', 'placeholder' => 'jean@exemple.com']
            ])
            ->add('serviceType', ChoiceType::class, [
                'choices' => [
                    'Tonte de Pelouse' => 'Mowing',
                    'Paysagisme' => 'Landscaping',
                    'Points d\'Eau' => 'Water Features',
                    'Élagage' => 'Pruning',
                    'Autre' => 'Other',
                ],
                'label' => 'Service Demandé',
                'attr' => ['class' => 'form-select']
            ])
            ->add('gardenSize', NumberType::class, [
                'label' => 'Surface Approx. du Jardin (m²)',
                'attr' => ['class' => 'form-input', 'placeholder' => '150']
            ])
            ->add('location', TextType::class, [
                'label' => 'Lieu (Ville/Code Postal)',
                'attr' => ['class' => 'form-input', 'placeholder' => 'Paris 75001']
            ])
            ->add('image', FileType::class, [
                'label' => 'Télécharger une photo du jardin (Optionnel)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG, WEBP)',
                    ])
                ],
                'attr' => ['class' => 'form-file']
            ])
            ->add('scheduledAt', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false, // We'll use JS to populate this
                'label' => 'Date et Heure Préférées',
                'attr' => ['class' => 'form-input', 'readonly' => true]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuoteRequest::class,
        ]);
    }
}
