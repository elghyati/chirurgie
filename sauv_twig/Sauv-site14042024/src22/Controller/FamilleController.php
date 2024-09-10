<?php

namespace App\Controller;

use App\Entity\Famille;
use App\Form\FamilleType;
use App\Repository\FamilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/famille")
 */
class FamilleController extends AbstractController {

    /**
     * @Route("/", name="famille_index")
     */
    public function index(FamilleRepository $repo) {
        $familles = $repo->findAll();
//        dump($familles);
        return $this->render('famille/index.html.twig', [
                    'familles' => $familles
        ]);
    }

    /**
     * @Route("/new", name="famille_create")
     * @Route("/{id}/edit", name="famille_edit")
     */
    public function form(Request $request, Famille $famille = null) {
        if (!$famille) {
            $famille = new Famille();
        } else {
            $famille->setImage(
                    new File($this->getParameter('upload_directory') . '/' . $famille->getcoverImage())
            );
        }

        $form = $this->createForm(FamilleType::class, $famille);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('Image')->getData();
// this condition is needed because the 'image' field is not required
// so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
// this is needed to safely include the file name as part of the URL
//                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $safeFilename = $originalFilename;
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

// Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                            $this->getParameter('upload_directory'),
                            $newFilename
                    );
                } catch (FileException $e) {
// ... handle exception if something happens during file upload
                }

// updates the 'imageFilename' property to store the PDF file name
// instead of its contents
                $famille->setImage($newFilename);
            }

// ... persist the $product variable or any other work
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($famille);
            $entityManager->flush();
//            return $this->render('famille/form.html.twig', [
//                        'formFamille' => $form->createView(),
//            ]);
            return $this->redirect($this->generateUrl('famille_index'));
        }
        /*
          if ($form->isSubmitted() && $form->isValid()) {
          // $form->getData() holds the submitted values
          // but, the original `$task` variable has also been updated
          $famille = $form->getData();
          $file = $famille->getcoverImage();
          $fileName = md5(uniqid()) . '.' . $file->guessExtension();
          $file->move($this->getParameter('upload_directory'), $fileName);
          $famille->setImage($fileName);
          // ... perform some action, such as saving the task to the database
          // for example, if Task is a Doctrine entity, save it!
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($famille);
          $entityManager->flush();

          return $this->redirectToRoute('famille_index');
          }
         */
        return $this->render('famille/form.html.twig', [
                    'formFamille' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="famille_show")
     */
    public function show(Famille $famille) {
        return $this->render('famille/show.html.twig', [
                    'famille' => $famille
        ]);
    }

    /**
     * @Route("/delete/{id}", name="famille_delete")
     */
    public function delete(Famille $famille) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($famille);
        $entityManager->flush();
        $familles = $this->getDoctrine()
                ->getRepository(Famille::class)
                ->findAll();
//        dump($familles);
        return $this->render('famille/index.html.twig', [
                    'familles' => $familles,
        ]);
    }

}
