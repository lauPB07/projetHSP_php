<?php

namespace App\Form;

use App\Entity\FicheEntreprise;
use App\Entity\Offre;
use App\Entity\TypeOffre;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Titre de l\'offre'],
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de l\'offre'],
            ])
            ->add('mission_lier', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Mission liée'],
            ])
            ->add('salaire', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Salaire proposé'],
            ])
            ->add('est_cloturer', null, [
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('ref_typeOffre', EntityType::class, [
                'class' => TypeOffre::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
