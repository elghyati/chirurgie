<?php

namespace App\Controller;

use App\Entity\HeaderImage;
use App\Form\HeaderImageType;
use App\Repository\HeaderImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/headerimage")
 */
class AdminHeaderImageController extends AbstractController
{
    /**
     * @Route("/", name="admin_headerimg_index")
     */
    public function index(HeaderImageRepository $headerImageRepository)
    {
        $imgheader = $headerImageRepository->findAll();
        return $this->render('admin/admin_header_image/index.html.twig', [
            'imgheaders' => $imgheader,
        ]);
    }

    /**
     * @Route("/new", name="admin_headerimg_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $headerimg = new HeaderImage();
        $form = $this->createForm(HeaderImageType::class, $headerimg);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($headerimg->getImageFile())) {
//                dd($headerimg);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($headerimg);
                $entityManager->flush();
                return $this->redirectToRoute('admin_headerimg_index');
            }
        }

        return $this->render('admin/admin_header_image/new.html.twig', [
            'headerimg' => $headerimg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_headerimg_show", methods={"GET"})
     */
    public function show(HeaderImage $headerimg): Response
    {
        return $this->render('admin/admin_header_image/show.html.twig', [
            'headerimage' => $headerimg,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_headerimg_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HeaderImage $headerimg): Response
    {
        $form = $this->createForm(HeaderImageType::class, $headerimg);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($headerimg);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_headerimg_index');
        }

        return $this->render('admin/admin_header_image/edit.html.twig', [
            'headerimage' => $headerimg,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_headerimg_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HeaderImage $headerimg): Response
    {
        if ($this->isCsrfTokenValid('delete' . $headerimg->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($headerimg);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_headerimg_index');
    }


}
