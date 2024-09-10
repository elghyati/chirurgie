<?php

namespace App\Controller;

//use Doctrine\Persistence\ObjectManager;


use App\Entity\Order;
use App\Form\AdminOrderType;
use App\Repository\OrderRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class AdminOrderController extends AbstractController {

    /**
     * @Route("/", name="admin_order_index", methods={"GET"})
     */
    public function index(OrderRepository $repo) {
        $orders = $repo->findAll();
//        dd($orders);
        return $this->render('admin/order/index.html.twig', [
                    'controller_name' => 'OrderController',
                    'orders' => $orders,
        ]);
    }

    /**
     * @Route("/new", name="admin_order_new", methods={"GET","POST"})
     */
    public function new(Request $request, OrderRepository $repo): Response {
        $order = new Order();

        $form = $this->createForm(AdminOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($order->getOrderDetails());
            foreach ($order->getOrderDetails() as $orderDetail) {
                $orderDetail->setRelatedOrder($order);
                $this->getDoctrine()->getManager()->persist($orderDetail);
            }
            $date = new DateTime();
            $order->setCreatedAt($date);  // New
            $order->setUpdatedAt($date);
            $lastOrder = $repo->findOneBy([], ['id' => 'desc']);
            if ($lastOrder) {
                $lastRef = $lastOrder->getReference();
                $seq = substr($lastRef, 5);
                $intSeq = (int) $seq;
            } else {
                $intSeq = 0;
            }

            $newSeq = str_pad(++$intSeq, 5, "0", STR_PAD_LEFT);
//            dd($lastRef, $seq, $intSeq, $newSeq);
            $reference = 'C' . $date->format('Y') . $newSeq;
            $order->setReference($reference);

            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_order_index');
        }
        return $this->render('admin/order/new.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
        ]);
    }

//    /**
//     * @Route("/new", name="order_create")
//     * @Route("/{id}/edit", name="admin_order_edit")
//     */
//    public function edit(Request $request, Order $order = null) {

    /**
     * @Route("/{id}/edit", name="admin_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response {
//        dd($order);
//        if (!$order) {
//            $order = new Order();
//        }

        $form = $this->createForm(AdminOrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($order->getOrderDetails());
            foreach ($order->getOrderDetails() as $orderDetail) {
                $orderDetail->setRelatedOrder($order);
                $this->getDoctrine()->getManager()->persist($orderDetail);
            }
//            $order->setCreatedAt(new DateTime());  // New
            $order->setUpdatedAt(new DateTime());
//            dd($order);
            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_order_index');
        }
        return $this->render('admin/order/edit.html.twig', [
                    'form' => $form->createView(),
                    'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_delete" , methods={"DELETE"})
     */
    public function delete(Request $request, Order $order) {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

//        $order = $this->getDoctrine()
//                ->getRepository(Order::class)
//                ->findAll();
//        return $this->render('admin_order_index', [
//                    'orders' => $order,
//        ]);
        return $this->redirectToRoute('admin_order_index');
    }

    /**
     * @Route("/{id}", name="admin_order_show", methods={"GET"})
     */
    public function show(Order $order): Response {
        return $this->render('admin/order/show.html.twig', [
                    'order' => $order,
        ]);
    }

//    /**
//     * @Route("/{id}/editdet", name="admin_order_detail")
//     */
//    public function editdetail(Order $order) {
//
////
////        $dorder = $this->getDoctrine()
////                ->getRepository(OrderDetail::class)
////                ->findByid($id);
////        dd($orders);
//        $form = $this->createForm(AdminOrderDetailType::class, $order->getOrderDetails()[0]);
//        $form->handleRequest($request);
//        return $this->render('admin/order/showdet.html.twig', [
//                    'controller_name' => 'OrderController',
//                    'dorders' => $dorder,
//        ]);
//    }
//    /**
//     * @Route("/{id}/edit", name="admin_order_detail", methods={"GET","POST"})
//     */
//    public function editDetail(Request $request, Order $order): Response
//    {
//        $form = $this->createForm(AdminOrderDType::class, $order);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('admin_order_index');
//        }
//
//        return $this->render('admin/order/edit.html.twig', [
//            'order' => $order,
//            'form' => $form->createView(),
//        ]);
//    }  
//    /**
//     * @Route("/shopdetail/{id}", name="admin_order_detail")
//     */
//    public function shopDetail(Order $order, SessionInterface $session, CartService $cartService) {
// 
//
//        return $this->render('order/shopdetail.html.twig', [
//                    'order' => $order,
//                    'items' => $cartService->getFullCart(),
//                    'total' => $cartService->getTotal()
//        ]);
//    }
}
