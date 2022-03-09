<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ProduitRepository $repo): Response
    {
        $products = $repo->findAll();

        return $this->render('produit/index.html.twig', [
            'produits' => $products
        ]);
    }

    #[Route('produit/add', name: 'produit_add')]
    public function add(Request $request, EntityManagerInterface $em, ProduitRepository $repo)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        // variable qui represente la vue du form
        $formView = $form->createView();

        if($form->isSubmitted()){
            $ref = strtoupper(substr($produit->getNom(), 0, 4));
            $count = $repo->countByRef($ref) + 1;
            $ref .= str_pad($count, 4, '0', STR_PAD_LEFT);
            $produit->setReference($ref);

            $produit->setDeleted(false);
            //dd($form->getData());
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success', 'Produit crée');
            return $this->redirectToRoute('app_produit');
        }


        return $this->render('produit/add.html.twig', [
            'p' =>$produit,
            'form' => $formView
        ]);
    }

    #[Route('/produit/edit/{id}', name: 'produit_edit')]
    public function edit($id, ProduitRepository $repo, Request $request)
    {
        $product = $repo->find($id);

        $form = $this->createForm(ProduitType::class, $product);

        $form->handleRequest($request);

        $formView = $form->createView();

        return $this->render('produit/edit.html.twig', [
            'product' => $product,
            'form' => $formView
        ]);
    }
}
