<?php

namespace App\Controller;



use App\Entity\Slugan;
use App\Form\AdminSluganType;
use App\Repository\SluganRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/slugan")
 */
class AdminSluganController extends AbstractController
{
    /**
     * @Route("/", name="admin_slugan_index")
     */
    public function index(SluganRepository $sluganRepository)
    {
        $slugans = $sluganRepository->findAll();
//        $slugans =$sluganRepository->findByDisplay('0');
//dd($slugans);
        return $this->render('admin/slugan/index.html.twig', [
            'slugans' => $slugans,
        ]);
    }

    /**
     * @Route("/new", name="admin_slugan_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $slugan = new Slugan();
        $form = $this->createForm(AdminSluganType::class, $slugan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slugan);
            $entityManager->flush();
            return $this->redirectToRoute('admin_slugan_index');
        }

        return $this->render('admin/slugan/new.html.twig', [
            'slugan' => $slugan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_slugan_show", methods={"GET"})
     */
    public function show(Slugan $slugan): Response
    {
        return $this->render('admin/slugan/show.html.twig', [
            'slugan' => $slugan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_slugan_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Slugan $slugan): Response
    {
        $form = $this->createForm(AdminSluganType::class, $slugan);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($slugan);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_slugan_index');
        }

        return $this->render('admin/slugan/edit.html.twig', [
            'slugan' => $slugan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_slugan_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Slugan $slugan): Response
    {
        if ($this->isCsrfTokenValid('delete' . $slugan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($slugan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_slugan_index');
    }


}
