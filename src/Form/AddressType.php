<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('streetNumber')
            ->add('bisTerInfo')
            ->add('streetName')
            ->add('postcode')
            ->add('city')
            ->add('extraInfo')
            //->add('department', DepartmentType::class, [
            //    'label' => 'department'
            //])
            //->add('billingAddress')
            //->add('deliveryAddress')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
