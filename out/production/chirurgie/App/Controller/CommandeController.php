<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Request;
use App\Entity\Commande;
use App\Form\CommandeType;

/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController {

    /**
     * @Route("/", name="commande_index")
     */
    public function index() {
        $commandes = $this->getDoctrine()
                ->getRepository(Commande::class)
                ->findAll();
//        dump($commandes);
        return $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/new", name="commande_create")
     * @Route("/{id}/edit", name="commande_edit")
     */
    public function form(Request $request, Commande $commande = null) {
        if (!$commande) {
            $commande = new Commande();
        }

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('commande_index'));
        }
        return $this->render('commande/form.html.twig', [
                    'formCommande' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="commande_show")
     */
    public function show(Commande $commande) {
        return $this->render('commande/show.html.twig', [
                    'commande' => $commande
        ]);
    }

    /**
     * @Route("/delete/{id}", name="commande_delete")
     */
    public function delete(Commande $commande) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commande);
        $entityManager->flush();
        $commandes = $this->getDoctrine()
                ->getRepository(Commande::class)
                ->findAll();
//        dump($commandes);
        return $this->render('commande/index.html.twig', [
                    'commandes' => $commandes,
        ]);
    }

}
