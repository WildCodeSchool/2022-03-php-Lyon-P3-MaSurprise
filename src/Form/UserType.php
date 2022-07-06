<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom*',
                'required' => 'Le champ Nom est obligatoire',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom*',
                'required' => 'Le champ Prénom est obligatoire',
            ])
            ->add('email', EmailType::class, [
                'label' => "E-mail*",
                'required' => "Le champ E-mail est obligatoire",
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => array('label' => 'Mot de passe*'),
                'second_options' => array('label' => 'Confirmez votre mot de passe*'),
                'constraints' => [
                    new NotBlank(['message' => "Ce champ est obligatoire."]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit comporter plus de {{ limit }} caractères.',
                    ]),
                ],
                'invalid_message' => 'Le mot de passe doit être identique.',
                'options' => ['attr' => [
                    'class' => 'password-field',
                    'placeholder' => "Mot de passe",
                ]],
            ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone*",
                'required' => "Le champ Téléphone est obligatoire"
                ])
            ->add('billingAddress', CollectionType::class, [
                'label' => "Adresse*",
                'required' => "Le champ Adresse est obligatoire",
                'entry_type' => AddressType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
