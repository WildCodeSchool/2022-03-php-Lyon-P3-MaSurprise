<?php

namespace App\Form;

use App\Entity\Baker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Department;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('services', ChoiceType::class, [
                'label' => 'Quelle(s) prestation(s) proposez-vous ?*',
                'choices' => ['pâtissier' => 'pâtissier', 'atelier' => 'atelier', 'formation' => 'formation'],
                'expanded' => true,
                'multiple' => true,
                ])
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
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => "E-mail",
                'required' => "Le champ e-mail est obligatoire"
            ])
            ->add('password', TextType::class, [
                'label' => "Mot de passe",
                'required' => "Le champ mot de passe est obligatoire"
            ])
            ->add('streetNumber', NumberType::class, [
                'label' => "Numéro de rue",
                'required' => false
            ])
            ->add('bisTerInfo', TextType::class, [
                'label' => "Informations complémentaires (bis, ter, bâtiment, etc.)",
                'required' => false
            ])
            ->add('streetName', TextType::class, [
                'label' => "Nom de la rue",
                'required' => "Le champ nom de rue est obligatoire"
            ])
            ->add('postcode', NumberType::class, [
                'label' => "Code postal",
                'required' => "Le champ code postal est obligatoire"
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'required' => "Le champ ville est obligatoire"
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'label' => "Département",
                'choice_label' => 'displayName',
                'required' => "Le champ département est obligatoire"
            ])
            ->add('extraInfo', TextType::class, [
                'label' => "Informations complémentaires concernant l'adresse",
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone",
                'required' => "Le champ téléphone est obligatoire"
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
            ->add('facebook', TextType::class, [
                'label' => "Facebook",
                ])
            ->add('instagram', TextType::class, [
                'label' => "Instagram",
                ])
        ;
        $builder->get('services')
            ->addModelTransformer(new CallbackTransformer(
                function ($servicesAsString) {
                    // transform the string back to an array
                    return explode(', ', $servicesAsString);
                },
                function ($servicesAsArray) {
                    // transform the array to a string
                    return implode(', ', $servicesAsArray);
                },
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Baker::class,
        ]);
    }
}
