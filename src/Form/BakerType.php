<?php

namespace App\Form;

use App\Entity\Baker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'required' => 'Le champ nom est obligatoire'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => 'Le champ prénom est obligatoire'
                ])
            ->add('commercialName', TextType::class, [
                'label' => "Nom de l'entreprise",
                'required' => "Le champ Nom de l'entreprise est obligatoire"
                ])
            ->add('email', EmailType::class, [
                'label' => "E-mail",
                'required' => "Le champ E-mail est obligatoire"
                ])
            ->add('password', TextType::class, [
                'label' => "Mot de passe",
                'required' => "Le champ Mot de passe est obligatoire"
                ])
            ->add('address', TextareaType::class, [
                'label' => "Adresse",
                'required' => "Le champ Adresse est obligatoire"
                ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone",
                'required' => "Le champ Nom de l'entreprise est obligatoire"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Baker::class,
        ]);
    }
}
