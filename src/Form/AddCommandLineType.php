<?php

namespace App\Form;

use App\Entity\LigneCommande;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommandLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'label' => 'Produit', //affichage du label
                'label_attr' => ['class' => 'form-label'], //ajouter des attribut au label
                'required' =>true,
                'attr' =>['class' => 'form-control']])

            ->add('quantite', NumberType::class, [
                'label' =>'Quantité',
                'label_attr' => ['class' => 'form-label'],
                'required' =>true,
                'attr' =>['class' => 'form-control']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneCommande::class,
        ]);
    }

}
