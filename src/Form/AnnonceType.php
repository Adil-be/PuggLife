<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $isCreation = $options["isCreation"];

        $builder
            ->add('title')
            ->add('dogs', CollectionType::class, [
                'entry_type' => DogType::class,
                'entry_options' => [
                    'label' => false,
                    'isCreation' => $isCreation
                ],
                'label' => 'Dogs',
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
            'isCreation' => false
        ]);
    }
}