<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\AdminBrandType;
use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/brand")
 */
class AdminBrandController extends AbstractController
{
//    /**
//     * @Route("/admin/brand", name="admin_brand")
//     */
//    public function index()
//    {
//        return $this->render('admin_brand/index.html.twig', [
//            'controller_name' => 'AdminBrandController',
//        ]);
//    }
//}
/**
     * @Route("/", name="admin_brand_index")
     */
    public function index(BrandRepository $repo) {
        $brands = $repo->findAll();
        return $this->render('admin/brand/index.html.twig', [
                    'controller_name' => 'AdminBrandController',
                    'brands' => $brands,
        ]);
    }



    //    admin_admin_brand_new

    /**
     * @Route("/new", name="admin_brand_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $brands = new Brand();

        $form = $this->createForm(AdminBrandType::class, $brands);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($brands);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_brand_index');
        }
        return $this->render('admin/brand/new.html.twig', [
                    'form' => $form->createView(),
                    'brand' => $brands,
        ]);
    }
    
    

    /**
     * @Route("/{id}", name="admin_brand_show", methods={"GET"})
     */
    public function show(Brand $brands): Response {
        return $this->render('admin/brand/show.html.twig', [
                    'brand' => $brands,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_brand_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Brand $brands): Response {
//        dd($order);

        $form = $this->createForm(AdminBrandType::class, $brands);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($brands);
            $this->getDoctrine()->getManager()->flush();

//            dd($order);

            return $this->redirectToRoute('admin_brand_index');
        }
        return $this->render('admin/brand/edit.html.twig', [
                    'form' => $form->createView(),
                    'brand' => $brands,
        ]);
    }


    
    

    /**
     * @Route("/{id}", name="admin_brand_delete" , methods={"DELETE"})
     */
    public function delete(Request $request,Brand $brands) {
        if ($this->isCsrfTokenValid('delete' . $brands->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($brands);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_brand_index');
    }
    
}
