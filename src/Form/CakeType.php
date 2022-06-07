<?php

namespace App\Form;

use App\Entity\Cake;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CakeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('picture1')
            ->add('picture2')
            ->add('picture3')
            ->add('picture4')
            ->add('picture5')
            ->add('description', TextType::class)
            ->add('allergens', TextType::class)
            ->add('price', NumberType::class)
            ->add('size', TextType::class)
            ->add('baker', null, ['choice_label' => 'fullname'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cake::class,
        ]);
    }
}
