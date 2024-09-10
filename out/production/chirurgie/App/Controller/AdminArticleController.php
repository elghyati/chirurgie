<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\AdminArticleType;
use App\Repository\ArticleRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class AdminArticleController extends AbstractController {

    /**
     * @Route("/", name="admin_article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response {
        return $this->render('admin/article/index.html.twig', [
                    'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $article = new Article();
        $form = $this->createForm(AdminArticleType::class, $article);
        $form->handleRequest($request);
//        dump($form);
//        if ($form->isSubmitted()) {
//            dump($form);
//        }
        if ($form->isSubmitted() && $form->isValid()) {
//            dd($form);
            foreach ($article->getImages() as $image) {
                $image->setArticle($article);
                $this->getDoctrine()->getManager()->persist($image);
            }
            foreach ($article->getVariants() as $variant) {
                $variant->setArticle($article);
                foreach ($variant->getImages() as $img) {
                    $img->setVariant($variant);
                    $this->getDoctrine()->getManager()->persist($img);
                }
                $this->getDoctrine()->getManager()->persist($variant);
            }
            $slugify = new Slugify();
            $slug = $slugify->slugify($article->getDesignation());
            $article->setSlug($slug);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/new.html.twig', [
                    'article' => $article,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_show", methods={"GET"})
     */
    public function show(Article $article): Response {
        return $this->render('admin/article/show.html.twig', [
                    'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response {
//        dd($form);
        dump($article);
        $form = $this->createForm(AdminArticleType::class, $article);
        $form->handleRequest($request);
//        $articleSizes = $article->getSizes();

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($form);
            foreach ($article->getImages() as $image) {
                $image->setArticle($article);
                $this->getDoctrine()->getManager()->persist($image);
            }
            foreach ($article->getVariants() as $variant) {
                $variant->setArticle($article);
                foreach ($variant->getImages() as $img) {
                    $img->setVariant($variant);
                    $this->getDoctrine()->getManager()->persist($img);
                }
                $this->getDoctrine()->getManager()->persist($variant);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('admin/article/edit.html.twig', [
                    'article' => $article,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_article_index');
    }

}
