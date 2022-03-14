<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
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

#[Route(['/commande'])]
class CommandeController extends AbstractController
{
    #[Route(path: '/', name: 'app_commande')]
    public function index(CommandeRepository $repo,Request $request): Response
    {
        $states = ['1' => "Pending", '2' => "InProgress"];
        $commandes = $repo->findAll();

        $commandes = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 2,
            $request->query->get('keyword')
        );

        $total = $repo->countBySearch($request->query->get('keyword'));

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
            "states" => $states,
            'total' =>$total
        ]);
    }

    #[Route('/add', name: 'commande_add')]
    public function add(Request $request, EntityManagerInterface $em, CommandeRepository $repo)
    {
        $commande = new Commande();
        $commande->addLigne(new LigneCommande());

        $form = $this->createForm(AddCommandeType::class, $commande);
        $form->handleRequest($request);
        $formView = $form->createView();

        if($form->isSubmitted()) {
            $commande->setCreationDate(new \DateTime());
            $commande->setEtat(1);

            $commande->setReference(1111112);
            $commande->setUpdateDate(new \DateTime());

            $em->persist($commande);
            //$em->flush();
            $this->addFlash('success', 'Produit crée');
            return $this->redirectToRoute('app_commande');
        }


        return $this->render('commande/add.html.twig', [
            'c' => $commande,
            'form' => $formView
        ]);
    }

    #[Route('/edit/{id}', name: 'commande_edit')]
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
