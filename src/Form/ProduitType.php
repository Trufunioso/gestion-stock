<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('reference', TextType::class, [
                'disabled' => true,
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('nom', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('prix', MoneyType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('stock', IntegerType::class, [
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
