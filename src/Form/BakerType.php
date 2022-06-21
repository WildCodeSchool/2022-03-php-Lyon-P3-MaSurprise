<?php

namespace App\Form;

use App\Entity\Baker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, [
                'label' => 'user'
            ])
            ->add('bakerType', ChoiceType::class, [
                'label' => 'Vous êtes :*',
                'choices' => ['professionnel' => 'professionnel', 'amateur' => 'amateur'],
                'expanded' => true,
                'multiple' => false,
                ])
            ->add('commercialName', TextType::class, [
                'label' => "Nom de l'entreprise",
                'required' => false,
                ])
            ->add('deliveryAddress', TextareaType::class, [
                'label' => "Adresse de livraison (si différente de l'adresse de facturation)",
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
