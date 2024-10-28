<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'required' => true, // S'assurer que le champ est requis
                'attr' => ['placeholder' => 'Entrez le type de l\'événement']
            ])
            ->add('titre')
            ->add('description')
            ->add('rue')
            ->add('cp')
            ->add('ville')
            ->add('element_sup')
            ->add('date', null, [
                'widget' => 'single_text'
            ])
            ->add('nbPlace')
            ->add('save', SubmitType::class, )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
