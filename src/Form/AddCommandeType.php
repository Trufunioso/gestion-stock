<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client',EntityType::class, [
                "class"=> Client::class,
                'query_builder' => function (ClientRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.deleted = 0');
                    },
                //affichage du label
                'label' =>'Client', //affichage du label
                'label_attr' => ['class' => 'form-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']
            ])
            ->add('lignes', CollectionType::class, [
                'entry_type' => AddCommandLineType::class,
                'allow_add' => true

            ])
//
//            ->add('produit', EntityType::class, [
//                "class" => Produit::class,
//                'query_builder' =>function (ProduitRepository $pr) {
//                return $pr->createQueryBuilder('p')
//                        ->where('p.stock > 0');
//                },
//                //affichage du label
//                'label' =>'Produit', //affichage du label
//                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
//                'required' =>true,  //le  champs est requis
//                'attr' =>['class' => 'form-control']
//            ])
//            ->add('qtt', NumberType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Commande::class
        ]);
    }
}
