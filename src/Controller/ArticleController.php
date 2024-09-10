<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Famille;
use App\Entity\HeaderImage;
use App\Entity\SousFamille;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\Cart\CartService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="article_index")
     */
    public function index(ArticleRepository $repo)
    {
//        $articles = $this->getDoctrine()
//                ->getRepository(Article::class)
//                ->findAll();
        $articles = $repo->findAll();
//        dump($articles);
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/gallery", name="article_cards")
     */
    public function showGallery(SessionInterface $session, CartService $cartService)
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
//        dump($articles);
        return $this->render('article/gallerie.html.twig', [
            'articles' => $articles,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    //TODO change url order

    /**
     * @Route("/new", name="article_create")
     * @Route("/{id}/edit", name="article_edit")
     */
    public function form(Request $request, ObjectManager $entityManager, Article $article = null)
    {
        if (!$article) {
            $article = new Article();
        } else {
            $article->setImage(
                new File($this->getParameter('upload_directory') . '/' . $article->getcoverImage())
            );
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {

                $slugger = new AsciiSlugger();
//                $originalSlug = $slugger->slug($this->firstName . ' ' . $this->lastName);
//                $this->slug = $originalSlug->lower();

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = strtolower($safeFilename . '.' . $imageFile->guessExtension());
                try {
                    $imageFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }
                $article->setImage($newFilename);
            }

//            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash('success', "L'article <strong>{$article->getDesignation()}</strong> a bien été ajouté !");
            return $this->redirect($this->generateUrl('article_index'));
        }
        return $this->render('article/form.html.twig', [
            'formArticle' => $form->createView(),
        ]);
    }

    /**
     * @Route("/shopdetail/{id}", name="article_detail")
     */
    public function shopDetail(Article $article, SessionInterface $session, CartService $cartService)
    {
//        $encoders = array(new XmlEncoder(), new JsonEncoder());
//        $normalizers = array(new GetSetMethodNormalizer());
//        $serializer = new Serializer($normalizers, $encoders);
//        dump($article->getVariants());
//        $jsonArticle = $serializer->serialize($article->getVariants(), 'json');
//        dd($this->getUser()->getCustomerType());
        return $this->render('article/shopdetail.html.twig', [
            'article' => $article,
//                    'jsonArticle' => $jsonArticle,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'customerType' => $this->getUser() ? $this->getUser()->getCustomerType() : "PRT"
        ]);
    }

    /**
     * @Route("/shop", name="article_shop")
     */
    public function shop(SessionInterface $session, CartService $cartService)
    {
        $sousFamille = null;
        $familles = $this->getDoctrine()
            ->getRepository(Famille::class)
            ->findBy(array(), array('norder' => 'ASC'));

//                ->findAll();
        $headerimg = $this->getDoctrine()
            ->getRepository(HeaderImage::class)
            ->findAll();

        if ($familles) {

            $sousFamilles = $familles[0]->getSousFamilles();
            $sousFamille = $sousFamilles[0];
        }

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(
                ['sousFamille' => $sousFamille],
                ['sousFamille' => 'ASC']
            );

        return $this->render('article/shop.html.twig', [

            'familles' => $familles,
            'sousFamille' => $sousFamille,
            'articles' => $articles,
            'headerimg' => $headerimg,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/subshop/{id}", name="article_sub_shop")
     */
    public function subShop($id, SessionInterface $session, CartService $cartService)
    {
//        dd($id);
        $familles = $this->getDoctrine()
            ->getRepository(Famille::class)
            ->findAll();
        $sousFamilles = $this->getDoctrine()
            ->getRepository(SousFamille::class)
            ->findAll();
        $arSousFamille = $this->getDoctrine()
            ->getRepository(SousFamille::class)
            ->findById($id);
        $sousFamille = $arSousFamille[0];
//        dd($sousFamille[0]);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBysousFamille($sousFamille);
//        dd($articles);
        $headerimg = $this->getDoctrine()
            ->getRepository(HeaderImage::class)
            ->findAll();


        return $this->render('article/shop.html.twig', [
            'familles' => $familles,
            'sousFamille' => $sousFamille,
            'articles' => $articles,
            'headerimg' => $headerimg,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="article_delete")
     */
    public function delete(Article $article)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

}
