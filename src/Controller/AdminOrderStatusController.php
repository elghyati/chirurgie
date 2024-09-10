<?php

namespace App\Controller;

use App\Entity\OrderStatus;
use App\Form\AdminOrderStatusType;
use App\Repository\OrderStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/order_status")
 */
class AdminOrderStatusController extends AbstractController {

    /**
     * @Route("/", name="admin_order_status_index")
     */
    public function index(OrderStatusRepository $repo) {
        $status = $repo->findAll();
        return $this->render('admin/order_status/index.html.twig', [
                    'controller_name' => 'AdminOrderStatusController',
                    'orderstatus' => $status,
        ]);
    }



    //    admin_order_status_new

    /**
     * @Route("/new", name="admin_order_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $status = new OrderStatus();

        $form = $this->createForm(AdminOrderStatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($status);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_order_status_index');
        }
        return $this->render('admin/order_status/new.html.twig', [
                    'form' => $form->createView(),
                    'orderstatus' => $status,
        ]);
    }
    
    

    /**
     * @Route("/{id}/edit", name="admin_order_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderStatus $status): Response {
//        dd($order);

        $form = $this->createForm(AdminOrderStatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($status);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_order_status_index');
        }
        return $this->render('admin/order_status/edit.html.twig', [
                    'form' => $form->createView(),
                    'orderstatus' => $status,
        ]);
    }


    
    

    /**
     * @Route("/{id}", name="admin_order_status_delete" , methods={"DELETE"})
     */
    public function delete(Request $request,OrderStatus $status) {
        if ($this->isCsrfTokenValid('delete' . $status->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($status);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_order_status_index');
    }
//show.html.twig
//new.html.twig
//edit.html.twig
}
