<?php

namespace App\Form;

use App\Entity\Department;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCakeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // TODO : modify cake/ route, will have to turn this form into a service somehow
        $builder
            ->add('search', SearchType::class, ['required' => false, 'label' => false])
            //TRY HEREUNDER
            ->add('department', EntityType::class, 
            [
                'mapped' => false,
                'class' => Department::class,
                'choice_label' => 'name' 
            ]
        )
            //END OF TRY
            ->setAction('/cake/')
            ->setMethod('POST');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
