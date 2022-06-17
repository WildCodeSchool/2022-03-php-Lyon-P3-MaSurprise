<?php

namespace App\Form;

use App\Entity\Baker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bakerType', ChoiceType::class, [
                'label' => 'Vous êtes :*',
                'choices' => ['professionnel' => 'professionnel', 'amateur' => 'amateur'],
                'expanded' => true,
                'multiple' => false,
                ])
            ->add('lastname', TextType::class, [
            'label' => 'Nom*',
            'required' => 'Le champ Nom est obligatoire'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom*',
                'required' => 'Le champ Prénom est obligatoire'
                ])
            ->add('commercialName', TextType::class, [
                'label' => "Nom de l'entreprise",
                'required' => false,
                ])
            ->add('logoFile', VichFileType::class, [
                'label' => 'Logo',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => true,
            ])
            ->add('siretFile', VichFileType::class, [
                'label' => 'Siret',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => true,
            ])
            ->add('diplomaFile', VichFileType::class, [
                'label' => 'CAP, autre diplôme ou accréditation',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => "E-mail*",
                'required' => "Le champ E-mail est obligatoire"
                ])
            ->add('password', TextType::class, [
                'label' => "Mot de passe*",
                'required' => "Le champ Mot de passe est obligatoire"
                ])
            ->add('address', TextareaType::class, [
                'label' => "Adresse*",
                'required' => "Le champ Adresse est obligatoire"
                ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone*",
                'required' => "Le champ Téléphone est obligatoire"
                ])
            ->add('facebook', TextType::class, [
                'label' => "Facebook",
                'required' => false,
                ])
            ->add('instagram', TextType::class, [
                'label' => "Instagram",
                'required' => false,
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
