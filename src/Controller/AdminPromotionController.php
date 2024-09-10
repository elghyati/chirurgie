<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\AdminPromotionType;
use App\Repository\ArrivalRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/promtion")
 */
class AdminPromotionController extends AbstractController
{
    /**
     * @Route("/", name="admin_promotion_index")
     */
    public function index(PromotionRepository $promotionRepository)
    {
        $promotions = $promotionRepository->findAll();
        return $this->render('admin/promotion/index.html.twig', [
            'promotions' => $promotions,
        ]);
    }

    /**
     * @Route("/new", name="admin_promotion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(AdminPromotionType::class, $promotion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($promotion->getImageFile())) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($promotion);
                $entityManager->flush();
                return $this->redirectToRoute('admin_promotion_index');
            }
        }
        return $this->render('admin/promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotion_show", methods={"GET"})
     */
    public function show(Promotion $promotion): Response
    {
        return $this->render('admin/promotion/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_promotion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotion $promotion): Response
    {
        $form = $this->createForm(AdminPromotionType::class, $promotion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($promotion);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_promotion_index');
        }

        return $this->render('admin/promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Promotion $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete' . $promotion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_promotion_index');
    }


}
