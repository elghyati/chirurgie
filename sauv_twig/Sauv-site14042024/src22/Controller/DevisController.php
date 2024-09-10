<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Cart\CartService;

class DevisController extends AbstractController {

    /**
     * @Route("/devis", name="devis")
     */
    public function index(SessionInterface $session, CartService $cartService) {
        return $this->render('devis/index.html.twig', [
                    'items' => $cartService->getFullCart(),
                    'total' => $cartService->getTotal()
        ]);
    }

}
