<?php

namespace App\Controller;

use App\Entity\Arrival;
use App\Form\AdminArrivalType;
use App\Repository\ArrivalRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/arrivage")
 */
class AdminArrivalController extends AbstractController
{
    /**
     * @Route("/", name="admin_arrivage_index")
     */
    public function index(ArrivalRepository $arrivalRepository)
    {
        $arrivals = $arrivalRepository->findAll();
//        $arrivals =$arrivalRepository->findByDisplay('0');
//dd($arrivals);
        return $this->render('admin/arrivage/index.html.twig', [
            'arrivales' => $arrivals,
        ]);
    }

    /**
     * @Route("/new", name="admin_arrivage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $arrival = new Arrival();
        $form = $this->createForm(AdminArrivalType::class, $arrival);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($arrival->getImageFile())) {
//                dd($arrival);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($arrival);
            $entityManager->flush();
            return $this->redirectToRoute('admin_arrivage_index');
            }
        }

        return $this->render('admin/arrivage/new.html.twig', [
            'arrivage' => $arrival,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_arrivage_show", methods={"GET"})
     */
    public function show(Arrival $arrival): Response
    {
        return $this->render('admin/arrivage/show.html.twig', [
            'arrival' => $arrival,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_arrivage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Arrival $arrival): Response
    {
        $form = $this->createForm(AdminArrivalType::class, $arrival);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($arrival);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_arrivage_index');
        }

        return $this->render('admin/arrivage/edit.html.twig', [
            'arrival' => $arrival,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_arrivage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Arrival $arrival): Response
    {
        if ($this->isCsrfTokenValid('delete' . $arrival->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($arrival);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_arrivage_index');
    }


}
