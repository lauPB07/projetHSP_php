<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Type de l\'événement',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le type de l\'événement'
                ],
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Titre de l\'événement'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez une description de l\'événement'
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Adresse de la rue'
                ],
            ])
            ->add('cp', TextType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Code postal'
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ville'
                ],
            ])
            ->add('element_sup', TextareaType::class, [
                'label' => 'Éléments supplémentaires',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez des détails supplémentaires'
                ],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de l\'événement',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('nbPlace', TextType::class, [
                'label' => 'Nombre de places disponibles',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nombre de places'
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
