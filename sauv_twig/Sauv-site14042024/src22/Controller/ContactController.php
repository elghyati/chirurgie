<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Cart\CartService;

class ContactController extends AbstractController {

    /**
     * @Route("/contact", name="contact")
     */
    public function index(SessionInterface $session, CartService $cartService) {
        return $this->render('contact/index.html.twig', [
                    'items' => $cartService->getFullCart(),
                    'total' => $cartService->getTotal()
        ]);
    }

}
