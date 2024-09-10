<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function dd;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController {

    /**
     * @Route("", name="cart_index")
     */
    public function index(SessionInterface $session, CartService $cartService) {
//        dd($panierWithData);
        return $this->render('cart/index.html.twig', [
                    'items' => $cartService->getFullCart(),
                    'total' => $cartService->getTotal()
        ]);
    }

//    /**
//     * @Route("/add/{id}", name="cart_add")
//     */

    /**
     * 
     * @Route("/add/{id}", name="cart_add")
     * @param type $id
     * @param Request $request
     * @param CartService $cartService
     * @return Response
     */
    public function add($id, Request $request, CartService $cartService): Response {
//        $form = $this->createForm(ArticleType::class, $article);
//        $form->handleRequest($request);
//        dd($request);
//        $qte = $request->query->get('quantity');
        $qte = $request->get('quantity');
//        dd($qte);
        $qte = $qte == null ? 1 : $qte;
        $cartService->add($id, $qte);
//        dd($cartService->getFullCart());
//        dd($session->get('panier'));
//        return $this->redirectToRoute('article_cards');
        $status = 200;
        return $this->json([
                    'id' => $id,
                    'qte' => $qte,
                    'query' => $request->query,
//                    'cartService' => $cartService,                //A circular reference exception Sousamille
                    'items' => $this->json($cartService->getJsonCart()), //A circular reference exception Sousamille
                    'total' => $cartService->getTotal()
                        ], $status);
    }

    /**
     * 
     * @Route("/getcart", name="cart_get")
     * @param CartService $cartService
     * @return Response
     */
    public function getCart(CartService $cartService): Response {
        $status = 200;
        return $this->json([
//                    'query' => $request->query,
                    'items' => $this->json($cartService->getJsonCart()), //A circular reference exception Sousamille
                    'total' => $cartService->getTotal()
                        ], $status);
    }

    /**
     * @Route("/remove/{id}", name="cart_remove")
     * @param type $id
     * @param CartService $cartService
     * @return Response
     * 
     */
    public function remove($id, CartService $cartService): Response {
        $cartService->remove($id);
//        dd($session->get('panier'));
//        return $this->redirectToRoute("cart_index");
        $status = 200;
        return $this->json([
//                    'query' => $request->query,
                    'items' => $this->json($cartService->getJsonCart()), //A circular reference exception Sousamille
                    'total' => $cartService->getTotal()
                        ], $status);
    }

    /**
     * @Route("/validate", name="cart_validate")
     */
    public function validateCart(SessionInterface $session, CartService $cartService, CustomerRepository $customerRepository) {
//        dd($session);
        if ($cartService->getTotal() > 0) {
            $order = new Order();
//            $customer = $customerRepository->findOneBy(['id' => 1109]);
//            $customer = $customerRepository->findOneBy(['id' => $this->getUser()->getId()]);
            dump($this->getUser());
            $customer = $this->getUser();
            dump($customer->getId());
            $order->setCustomer($customer);
            $order->setStatus(1);
            $order->setAmount($cartService->getTotal());
            $order->setCreatedAt(new \DateTime('now'));
            $panierWithData = $cartService->getFullCart();
//            dd($panierWithData);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $i = 0;
            foreach ($panierWithData as $cart) {
                $i++;
//                dd($cart);
                $article = $cart['article'];
                $quantity = $cart['quantity'];
                $orderDetail = new OrderDetail();
                $orderDetail->setSequence($i);
                $orderDetail->setArticle($article);
                $orderDetail->setQuantity($quantity);
                $orderDetail->setPrice($article->getPrice());
                $orderDetail->setSubTotal($quantity * $article->getPrice());
                $orderDetail->setRelatedOrder($order);
                $entityManager->persist($orderDetail);
            }
            $entityManager->flush();
            $cartService->resetCart();
        } else {
            $this->addFlash("danger", "Impossible de valider ce panier ! ");
        }
//        return $this->redirect($this->generateUrl('cart_index'));
        return $this->redirectToRoute("cart_index");
    }
    
    

    /**
     * @Route("/validate", name="cart_PriceRequest_validate")
     */
    public function validatPriceRequesteCart(SessionInterface $session, CartService $cartService, CustomerRepository $customerRepository) {
        return $this->redirectToRoute("cart_index");
    }
}
