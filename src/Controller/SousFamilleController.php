<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Request;
use \Doctrine\Common\Persistence\ObjectManager;
use \App\Entity\SousFamille;
use \App\Form\SousFamilleType;

/**
 * @Route("/sousfamille")
 */
class SousFamilleController extends AbstractController {

    /**
     * @Route("/", name="sous_famille_index")
     */
    public function index() {
        $sous_familles = $this->getDoctrine()
                ->getRepository(SousFamille::class)
                ->findAll();
//        dump($sous_familles);
        return $this->render('sous_famille/index.html.twig', [
                    'sous_familles' => $sous_familles,
        ]);
    }

    /**
     * @Route("/new", name="sous_famille_create")
     * @Route("/{id}/edit", name="sous_famille_edit")
     */
    public function form(Request $request, SousFamille $sous_famille = null) {
        if (!$sous_famille) {
            $sous_famille = new SousFamille();
        }

        $form = $this->createForm(SousFamilleType::class, $sous_famille);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sous_famille = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sous_famille);
            $entityManager->flush();

            return $this->redirectToRoute('sous_famille_index');
        }

        return $this->render('sous_famille/form.html.twig', [
                    'formSousFamille' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="sous_famille_show")
     */
    public function show(SousFamille $sous_famille) {
        return $this->render('sous_famille/show.html.twig', [
                    'sous_famille' => $sous_famille
        ]);
    }

    /**
     * @Route("/delete/{id}", name="sous_famille_delete")
     */
    public function delete(SousFamille $sous_famille) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($sous_famille);
        $entityManager->flush();
        $sous_familles = $this->getDoctrine()
                ->getRepository(SousFamille::class)
                ->findAll();
        return $this->render('sous_famille/index.html.twig', [
                    'sous_familles' => $sous_familles,
        ]);
    }

}
