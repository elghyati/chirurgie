<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Form\AdminFamilleType;
use App\Repository\FamilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/famille")
 */
class AdminFamilleController extends AbstractController
{
    /**
     * @Route("/", name="admin_famille_index", methods={"GET"})
     */
    public function index(FamilleRepository $familleRepository): Response
    {
        return $this->render('admin/famille/index.html.twig', [
            'familles' => $familleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_famille_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $famille = new Famille();
        $form = $this->createForm(AdminFamilleType::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($famille);
            $entityManager->flush();

            return $this->redirectToRoute('admin_famille_index');
        }

        return $this->render('admin/famille/new.html.twig', [
            'famille' => $famille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_famille_show", methods={"GET"})
     */
    public function show(Famille $famille): Response
    {
        return $this->render('admin/famille/show.html.twig', [
            'famille' => $famille,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_famille_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Famille $famille): Response
    {
        $form = $this->createForm(AdminFamilleType::class, $famille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_famille_index');
        }

        return $this->render('admin/famille/edit.html.twig', [
            'famille' => $famille,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_famille_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Famille $famille): Response
    {
        if ($this->isCsrfTokenValid('delete'.$famille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($famille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_famille_index');
    }
}
