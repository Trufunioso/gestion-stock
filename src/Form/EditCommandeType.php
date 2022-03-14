<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCommandeType extends AbstractType
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
            ->add('updateDate', DateType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('creationDate', DateType::class, [
                'disabled' => true,
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control']
            ])
            ->add('etat', TextType::class,[
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('client',EntityType::class,[
                "class"=> Client::class,
                'query_builder' => function (ClientRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.deleted = 0');},
                //affichage du label
                'label' =>'client', //affichage du label
                'label_attr' => ['class' => 'forme-label'], //ajouter des attribut au label
                'required' =>true,  //le  champs est requis
                'attr' =>['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
