<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Cart\CartService;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact")
     */
    public function index(SessionInterface $session, CartService $cartService, Request $request, MailerInterface $mailer)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $content = 'Nom :' .$contact->getFirstname() . ' ' . $contact->getLastname() . "\r\n" .
                ' GSM : ' . $contact->getPhone(). "\r\n";
            $content .=$contact->getMessage();
            $contact->setMessage($content);
            $email = (new Email())
//                ->from($contact->getEmail())
                ->from($contact->getEmail())
//                ->to('a.elghyati@gmail.com')
//                    ->to('springpcard@gmail.com')
//                ->to('a.elghyati@gmail.com')
                ->to('springpcard@gmail.com')
//                ->to($contact->getEmail())

                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                ->replyTo($contact->getEmail())
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Essai de site Mail')

//                ->text($contact->getMessage())
//                    ->html($contact->getMessage());
                    ->html($content);

            if (!$mailer->send($email)){
                $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
                $this->addFlash('success', $msg);
            } else {
                $msg = 'Message envoyé ! Merci de nous avoir contactés.';
//                $this->addFlash('success', 'Votre email a bien été envoyé ');
                $this->addFlash('success', $msg);
            }

            return $this->redirectToRoute('home_index');
        }

        return $this->render('contact/index.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'form' => $form->createView()

        ]);
    }

}
