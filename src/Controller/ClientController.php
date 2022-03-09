<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\AddClientType;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client')]
    public function index(Request $request, ClientRepository $repo): Response
    {
//        $clients = $repo->findBy([
//            'deleted' => false,
//            'nom' => 'LY'
//        ]);
        $clients = $repo->findBySearch(
            $request->query->get('offset'),
            $request->query->get('limit') ?: 2,
            $request->query->get('keyword')
        );

        $total = $repo->countBySearch($request->query->get('keyword'));

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'total' => $total
        ]);
    }

    #[Route('/client/add', name: 'client_add')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        ClientRepository $repo
    )
    {
        $client = new Client();
        $form = $this->createForm(AddClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ref = substr($client->getNom(), 0 , 2);
            $ref .= substr($client->getPrenom(), 0 , 2);
            $count = $repo->countByRef($ref) + 1;
            $ref .= (str_pad($count, 4, '0', STR_PAD_LEFT));
            $ref = strtoupper($ref);
            $client->setReference($ref);
            $client->setDeleted(false);
            // enregistrement local des changements
            $em->persist($client);
            //suppression d'un client
            // $em->remove($client);
            // sauvegarde dans la db;
            $em->flush();
            $this->addFlash('success', 'Enregistrement OK');
            return $this->redirectToRoute('client');
        }

        return $this->render('client/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/client/delete/{id}', name: 'client_delete')]
    public function delete($id, ClientRepository $repo, EntityManagerInterface $em)
    {
        $client = $repo->find($id);
        if($client === null || $client->getDeleted()) {
            throw new NotFoundHttpException();
        }
        //$em->remove($client);
        $client->setDeleted(true);
        $em->flush();
        $this->addFlash('success', 'Suppression OK');
        return $this->redirectToRoute('client');
    }

    #[Route('/client/edit/{id}', name: 'client_edit')]
    public function edit($id, ClientRepository $repo, Request $request, EntityManagerInterface $em)
    {
        $client = $repo->find($id);

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        $formView = $form->createView();

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'edit OK');

            return $this->redirectToRoute('client');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $formView
            ]);
    }






}
