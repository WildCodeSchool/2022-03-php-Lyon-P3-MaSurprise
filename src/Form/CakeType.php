<?php

namespace App\Form;

use App\Entity\Cake;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CakeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('picture1File', VichFileType::class, [
                'label' => 'Image 1',
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('picture2', TextType::class, ['label' => 'Image 2'])
            ->add('picture3', TextType::class, ['label' => 'Image 3'])
            ->add('picture4', TextType::class, ['label' => 'Image 4'])
            ->add('picture5', TextType::class, ['label' => 'Image 5'])
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('allergens', TextType::class, ['label' => 'Liste des allergènes'])
            ->add('price', NumberType::class, ['label' => 'Prix'])
            ->add('size', TextType::class, ['label' => 'Taille'])
            ->add('baker', null, ['label' => 'Pâtissier', 'choice_label' => 'fullname'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cake::class,
        ]);
    }
}
