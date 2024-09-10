<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AboutusController extends AbstractController {

    /**
     * @Route("/aboutus", name="aboutus")
     */
    public function index(SessionInterface $session, CartService $cartService) {
        return $this->render('aboutus/index.html.twig', [
                    'items' => $cartService->getFullCart(),
                    'total' => $cartService->getTotal()
        ]);
    }

}
