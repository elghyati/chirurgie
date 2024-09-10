<?php

namespace App\Controller;

use App\Entity\SousFamille;
use App\Form\AdminSousFamilleType;
use App\Repository\SousFamilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/sousfamille")
 */
class AdminSousFamilleController extends AbstractController {

    /**
     * 
     * @Route("/", name="admin_sous_famille_index", methods={"GET"})
     */
    public function index(SousFamilleRepository $sousFamilleRepository): Response {
        return $this->render('admin/sous_famille/index.html.twig', [
                    'sous_familles' => $sousFamilleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_sous_famille_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $sousFamille = new SousFamille();
        $form = $this->createForm(AdminSousFamilleType::class, $sousFamille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sousFamille);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sous_famille_index');
        }

        return $this->render('admin/sous_famille/new.html.twig', [
                    'sous_famille' => $sousFamille,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_sous_famille_show", methods={"GET"})
     */
    public function show(SousFamille $sousFamille): Response {
        return $this->render('admin/sous_famille/show.html.twig', [
                    'sous_famille' => $sousFamille,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_sous_famille_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SousFamille $sousFamille): Response {
        $form = $this->createForm(AdminSousFamilleType::class, $sousFamille);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_sous_famille_index');
        }

        return $this->render('admin/sous_famille/edit.html.twig', [
                    'sous_famille' => $sousFamille,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_sous_famille_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SousFamille $sousFamille): Response {
        if ($this->isCsrfTokenValid('delete' . $sousFamille->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sousFamille);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_sous_famille_index');
    }

}
