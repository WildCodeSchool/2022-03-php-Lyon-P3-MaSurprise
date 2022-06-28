<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('streetNumber', NumberType::class, [
                'label' => 'Numéro de rue'
            ])
            ->add('bisTerInfo', TextType::class, [
                'label' => 'Bis ou Ter',
                'required' => false
            ])
            ->add('streetName', TextType::class, [
                'label' => 'Nom de la rue*',
                'required' => 'Le nom de la rue est obligatoire'
            ])
            ->add('postcode', NumberType::class, [
                'label' => 'Code postal*',
                'required' => 'Le champ code postal est obligatoire',
                'constraints' => [
                    new Length([
                    'min' => 5,
                    'max' => 5,
                    'minMessage' => 'Le code postal doit comporter 5 chiffres.',
                    ])
                ]
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false,
                'label' => 'Département*'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville*',
                'required' => 'Le champ ville est obligatoire'
            ])
            ->add('extraInfo', TextType::class, [
                'label' => 'Informations supplémentaires',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
