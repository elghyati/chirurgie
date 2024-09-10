<?php

namespace App\Controller;

use App\Entity\MiddleSlide;
use App\Form\AdminMiddleSlideType;
use App\Repository\MiddleSlideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin/middle")
 */
class AdminMiddleSlideController extends AbstractController
{
    /**
     * @Route("/", name="admin_middle_index")
     */
    public function index(MiddleSlideRepository $middleSlideRepository)
    {
        $middles = $middleSlideRepository->findAll();

        return $this->render('admin/middle_slide/index.html.twig', [
            'middles' => $middles,
        ]);
    }

    /**
     * @Route("/new", name="admin_middle_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $middle = new MiddleSlide();
        $form = $this->createForm(AdminMiddleSlideType::class, $middle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($middle->getImageFile())) {
//                dd($middle);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($middle);
                $entityManager->flush();
                return $this->redirectToRoute('admin_middle_index');
            }
        }

        return $this->render('admin/middle_slide/new.html.twig', [
            'middle' => $middle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_middle_show", methods={"GET"})
     */
    public function show(MiddleSlide $middle): Response
    {
        return $this->render('admin/middle_slide/show.html.twig', [
            'middle' => $middle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_middle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MiddleSlide $middle): Response
    {
        $form = $this->createForm(AdminMiddleSlideType::class, $middle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($middle);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_middle_index');
        }

        return $this->render('admin/middle_slide/edit.html.twig', [
            'middle' => $middle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_middle_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MiddleSlide $middle): Response
    {
        if ($this->isCsrfTokenValid('delete' . $middle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($middle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_middle_index');
    }

}
