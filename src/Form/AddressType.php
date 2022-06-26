<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'streetNumber',
                NumberType::class,
                [
                    'label' => 'Numéro de rue',
                ]
            )
            ->add(
                'bisTerInfo',
                TextType::class,
                [
                    'label' => 'Complément',
                ]
            )
            ->add(
                'streetName',
                TextType::class,
                [
                    'label' => 'Nom de la rue',
                ]
            )
            ->add(
                'postcode',
                NumberType::class,
                [
                    'label' => 'Code postal',
                ]
            )
            ->add(
                'city',
                TextType::class,
                [
                    'label' => 'Ville',
                ]
            )
            ->add(
                'extraInfo',
                TextType::class,
                [
                    'label' => 'Informations complémentaires',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
