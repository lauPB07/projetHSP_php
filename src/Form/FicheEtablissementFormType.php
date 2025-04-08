<?php

namespace App\Form;

use App\Entity\FicheEtablissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheEtablissementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_etablissement', TextType::class, [
                'label' => 'Nom de l\'etablissement',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de l\'etablissement'
                ],
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'adresse de la rue'
                ],
            ])
            ->add('cp', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le code postal'
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez la ville'
                ],
            ])
            ->add('adresse_web', UrlType::class, [
                'label' => 'Adresse web',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'URL du site web'
                ],
            ])
            ->add('Save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FicheEtablissement::class,
        ]);
    }
}
