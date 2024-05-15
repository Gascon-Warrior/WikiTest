<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Type;

class SearchAvailabilitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner une date de début.']),
                    new Type(['type' => 'DateTime', 'message' => 'Veuillez entrer une date de début dans un format valide exemple: 01/06/2024']),
                    new GreaterThan(['value' => 'today', 'message' => 'La date de début doit être ultérieure à aujourd\'hui.']),
                ],
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner une date de fin.']),
                    new Type(['type' => 'DateTime', 'message' => 'Veuillez entrer une date de fin dans un format valide exemple: 01/06/2024']),
                    new GreaterThan(['propertyPath' => 'parent.all[date_debut].data', 'message' => 'La date de fin doit être ultérieure à la date de début.'])
                ],
            ])
            ->add('prix_max', MoneyType::class, [
                'mapped' => false,
                'scale' => 0,
                'label' => 'Prix maximum par jour',
                'required' => false,
                'constraints' => [
                    new Positive(['message' => 'Le prix doit être supérieur à 0.']),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
