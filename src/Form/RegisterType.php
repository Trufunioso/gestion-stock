<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom de Famille', // affichage du label
                'label_attr' => ['class' => 'form-label'], // ajouter des attribut au label
                'disabled' => false, // désactiver le champs
                'required' => true, // le champs est requis
                'attr' => ['class' => 'form-control'] // ajouter des attibuts à l'input
            ])
            ->add('firstName', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control'],
                'required' => true
            ])
            ->add('birthDate', BirthdayType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
            ])
            ->add('titre', ChoiceType::class, [
                'choices' => [
                    // ce que l'on va afficher => ce que l'on va sauvegarder
                    'Monsieur' => 'M.',
                    'Madame' => 'Mme',
                    'Mademoiselle' => 'Mlle'
                ],
                'attr' => ['class' => 'form-select']
                // 'expanded' => true, // des radios ou des checkboxes
                // 'multiple' => true // select multiple ou checkboxes
            ])
            ->add('cv', FileType::class, [
                'label_attr' => ['class' => 'form-label'],
                'constraints' => [
                    new File(['maxSize' => '2m', 'mimeTypes' => ['application/pdf']])
                ]
            ])
            ->add('consent', CheckboxType::class, [
                'label' => 'J\'accepte les cond ...'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}