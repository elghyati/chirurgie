<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Cart\CartService;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="home_index")
     */
    public function index(SessionInterface $session, CartService $cartService) {
        return $this->render('home/index.html.twig', [
                    'items' => $cartService->getFullCart(),
                    'total' => $cartService->getTotal()
        ]);
    }
}
