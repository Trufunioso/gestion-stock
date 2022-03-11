<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\AddCommandeType;
use App\Form\EditCommandeType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $repo): Response
    {
        $commandes = $repo->findAll();

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'commandes' => $commandes
        ]);
    }

    #[Route('/commande/add', name: 'commande_add')]
    public function add(Request $request, EntityManagerInterface $em, CommandeRepository $repo)
    {
        $commande = new Commande();

        $form = $this->createForm(AddCommandeType::class, $commande);
        $form->handleRequest($request);
        $formView = $form->createView();

        if($form->isSubmitted()) {
            $commande->setCreationDate(new \DateTime());
            $commande->setEtat(1);

            dd($form->getData());
        }


        return $this->render('commande/add.html.twig', [
            'c' => $commande,
            'form' => $formView
        ]);
    }

    #[Route('/commande/edit/{id}', name: 'commande_edit')]
    public function edit($id, CommandeRepository $repo,EntityManagerInterface $em, Request $request)
    {
        $commande = $repo->find($id);
        $form = $this->createForm(EditCommandeType::class, $commande);
        $form->handleRequest($request);

        $formView = $form->createView();

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'edit OK');
            return $this->redirectToRoute('app_commande');
        }


        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $formView
        ]);
    }


}
