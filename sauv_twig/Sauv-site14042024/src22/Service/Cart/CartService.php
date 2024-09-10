<?php

namespace App\Service\Cart;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {

    protected $session;
    protected $articleRepository;

    public function __construct(SessionInterface $session, ArticleRepository $articleRepository) {
        $this->session = $session;
        $this->articleRepository = $articleRepository;
    }

    public function add(int $id, int $quantity = 0) {
        $panier = $this->session->get('panier', []);
        if ($quantity == 0) {
            if (!empty($panier[$id])) {
                $panier[$id]++;
            } else {
                $panier[$id] = 1;
            }
        } else {
            $panier[$id] = $quantity;
        }
        $this->session->set('panier', $panier);
//        dd($this->session->get('panier'));
    }

    public function remove(int $id) {
        $panier = $this->session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'article' => $this->articleRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }

    public function getJsonCart(): array {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $article = $this->articleRepository->find($id);
            $panierWithData[] = [
                'id' => $article->getId(),
                'reference' => $article->getReference(),
                'designation' => $article->getDesignation(),
                'image' => $article->getcoverImage(),
                'puht' => $article->getPrice(),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }

    public function getTotal(): float {

        $panierWithData = $this->getFullCart();
        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['article']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
        return $total;
    }

    public function resetCart() {
        $panier = $this->session->get('panier', []);
        $panier = array();
        $this->session->set('panier', $panier);
        // dd($this->session->get('panier'));
    }

}
