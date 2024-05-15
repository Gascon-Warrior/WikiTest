<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'label' => 'Marque du véhicule',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ marque doit être renseigné']),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le champ marque doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le champ marque doit faire {{ limit }} caractères maximum.',
                    ])
                ],
            ])
            ->add('modele', TextType::class, [
                'label' => 'Modèle du véhicule',
                'constraints' => [
                    new NotBlank(['message' => 'Le champ modèle doit être renseigné']),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le champ modèle doit faire {{ limit }} caractères minimum.',
                        'maxMessage' => 'Le champ modèle doit faire {{ limit }} caractères maximum.',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
