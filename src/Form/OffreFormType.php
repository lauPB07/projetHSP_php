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
            ->add('titre')
            ->add('description')
            ->add('mission_lier')
            ->add('salaire')
            ->add('est_cloturer')
            ->add('ref_EntrepriseCreer', EntityType::class, [
                'class' => FicheEntreprise::class,
                'choice_label' => 'nom_entreprise', // Assurez-vous de spécifier la propriété appropriée
                'multiple' => true,
                'expanded' => false, // ou false pour un select au lieu de checkboxes
            ])
            ->add('ref_typeOffre', EntityType::class, [
                'class' => TypeOffre::class,
'choice_label' => 'nom',
            ])
            ->add('Save', SubmitType::class)
        ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
            'entreprises' => [],
        ]);
    }
}
