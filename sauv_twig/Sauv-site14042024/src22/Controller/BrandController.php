<?php 
    namespace App\Controller;
    use App\Repository\BrandRepository;
    use App\Service\Cart\CartService;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Annotation\Route;
    class BrandController extends AbstractController {    
        /**     
        * @Route("/brand", name="brand_index")     
        */    
        public function index(BrandRepository $brandRepository, SessionInterface $session, CartService $cartService) {
            //        dd($brandRepository->findAll());        
            return $this->render('brand/index.html.twig', [                    'items' => $cartService->getFullCart(),                    'total' => $cartService->getTotal(),                    
                'brands' => $brandRepository->findAll(),        
                ]);   
        }
        
    }