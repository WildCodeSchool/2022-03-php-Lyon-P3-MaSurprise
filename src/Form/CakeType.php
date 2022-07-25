<?php

namespace App\Form;

use App\Entity\Cake;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CakeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du gâteau',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ nom doit comporter au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'max' => 600,
                        'maxMessage' => 'Le champ prénom doit comporter au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('allergens', TextType::class, ['label' => 'Liste des allergènes'])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'max' => 3,
                        'maxMessage' => 'Le champ prénom doit comporter au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('size', TextType::class, [
                'label' => 'Taille',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le champ prénom doit comporter au maximum {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Pièce montée' => 'Pièce montée',
                    'Cupcake(s)' => 'Cupcake(s)',
                    'Spécialité(s) étrangère(s)' => 'Spécialité(s) étrangère(s)',
                    'Mini gâteau' => 'Mini gâteau',
                    'Patisserie(s)' => 'Patisserie(s)',
                    'Gâteau junior' => 'Gâteau junior',
                    'Gâteau sculpté' => 'Gâteau sculpté',
                    'Magnum cake(s)' => 'Magnum cake(s)',
                    'Pop cake(s)' => 'Pop cake(s)',
                ],
                'required' => true
            ])
            ->add('availability', TextType::class, ['label' => 'Disponibilité'])
            ->add('baker', null, ['label' => 'Pâtissier', 'choice_label' => function ($baker) {
                return $baker->getUser()->getFirstname() . ' ' . $baker->getUser()->getLastname();
            },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cake::class,
        ]);
    }
}
