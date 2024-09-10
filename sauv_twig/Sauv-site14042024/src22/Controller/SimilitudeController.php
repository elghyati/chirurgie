<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Request;
use \Doctrine\Common\Persistence\ObjectManager;
use \App\Form\SimilitudeType;
use \App\Entity\Similitude;

/**
 * @Route("/similitude")
 */
class SimilitudeController extends AbstractController {

    /**
     * @Route("/", name="similitude_index")
     */
    public function index() {
        $similitudes = $this->getDoctrine()
                ->getRepository(Similitude::class)
                ->findAll();
//        dump($similitudes);
        return $this->render('similitude/index.html.twig', [
                    'similitudes' => $similitudes,
        ]);
    }

    /**
     * @Route("/new", name="similitude_create")
     * @Route("/{id}/edit", name="similitude_edit")
     */
    public function form(Request $request, Similitude $similitude = null) {
        if (!$similitude) {
            $similitude = new Similitude();
        }

        $form = $this->createForm(SimilitudeType::class, $similitude);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $similitude = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($similitude);
            $entityManager->flush();

            return $this->redirectToRoute('similitude_index');
        }

        return $this->render('similitude/form.html.twig', [
                    'formSimilitude' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="similitude_show")
     */
    public function show(Similitude $similitude) {
        return $this->render('similitude/show.html.twig', [
                    'similitude' => $similitude
        ]);
    }

    /**
     * @Route("/delete/{id}", name="similitude_delete")
     */
    public function delete(Similitude $similitude) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($similitude);
        $entityManager->flush();
        $similitudes = $this->getDoctrine()
                ->getRepository(Similitude::class)
                ->findAll();
        return $this->render('similitude/index.html.twig', [
                    'similitudes' => $similitudes,
        ]);
    }

}
