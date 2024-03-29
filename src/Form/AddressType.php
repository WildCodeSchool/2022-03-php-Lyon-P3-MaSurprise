<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('streetNumber', NumberType::class, [
                'label' => 'Numéro de rue',
                'required' => false,
            ])
            ->add('bisTerInfo', TextType::class, [
                'label' => 'Complément de numéro',
                'required' => false,
            ])
            ->add('streetName', TextType::class, [
                'label' => 'Nom de la rue*',
                'required' => 'Le nom de la rue est obligatoire',
            ])
            ->add('department', null, ['label' => 'Département*', 'choice_label' => function ($department) {
                return $department->getNumber() . ' - ' . $department->getName();
            },
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Code postal*',
                'required' => 'Le champ code postal est obligatoire',
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'minMessage' => 'Le code postal doit comporter 5 chiffres.',
                    ]),
                    new Regex(array(
                        'pattern'   => '/^[0-9]+$/',
                        'match'     => true,
                        'message'   => 'Le code postal doit comporter 5 chiffres.'
                    ))
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville*',
                'required' => 'Le champ ville est obligatoire',
            ])
            ->add('extraInfo', TextType::class, [
                'label' => 'Informations complémentaires',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
