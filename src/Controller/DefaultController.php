<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(path: '/', name: 'default_home')]
    public function home(Request $request): Response
    {
        // $request->query contient tous les parametres "GET" <=> $_GET
        // $request->query;
        // contient tous les parametres "POST" <=> $_POST
        // $request->request
        // contient les variables de sessions <=> $_SESSION
        // $request->getSession();
        // permet de récupérer la valeur de $_GET['name']
        $name = $request->query->get('name');
        dump($name);
        return $this->render('default/home.html.twig');
    }

    #[Route(
        path: '/contact/{id}',
        name: 'default_contact',
        requirements: [
            // id doit etre un nombre
            'id' => '\d+'
        ], defaults: [
            'id' => 1
        ]
    )]
    public function contact(int $id) {
        dump($id);
        if($id === 1) {
            $model = 'Khun';
        }
        else if($id === 2) {
            $model = 'Flavian';
        }
        else {
            // déclencher une erreur 404
            throw new NotFoundHttpException();
        }
        return $this->render('default/contact.html.twig', [
            'model' => $model
        ]);
    }

    #[Route(
        path: '/contact_us',
        name: 'default_contact_us'
    )]
    public function contactUs(Request $request, MailerInterface $mailer) {
        // recupération des données en post (Ne pas utilser de cette manière mais passer par les FormTypes)
//        $email = $request->request->get('email');
//        $content = $request->request->get('content');
        // création d'un message vide
        $message = new Message();
        // dump($message);
        // fonction des controllers qui permet de créer un formulaire
        $form = $this->createForm(MessageType::class, $message);
        // remplir / hydrater le message
        $form->handleRequest($request);
        // dump($message);

        if($form->isSubmitted()  && $form->isValid() ) {
            // envoyer dans la db ou envoyer un email ,...
            $email = new Email();
            $email->to('lykhun@gmail.com');
            $email->from('noreply.bformation@gmail.com');
            $email->subject(sprintf(
                "L'utilisateur %s vous a envoyé un message",
                $message->getEmail()
            ));
            //$email->html(sprintf("<p>%s</p>", $message->getContent()));
            $email->html($this->renderView('mail/contact_us.html.twig',[
                'model' => $message
            ]));
            try {
                $mailer->send($email);
                //notification ok
                $this->addFlash('success', 'Votre message a bien été envoyé');
            } catch (TransportExceptionInterface) {
                //notification pas ok
                $this->addFlash('error', 'Une erreur est survenue, vueillez nous en excuser');
            }
            return $this->redirectToRoute('default_home');
        }
        return $this->render('default/contact_us.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/register', name: 'default_register')]
    public function register(Request $request) {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        dump($user);

        return $this->render('default/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
