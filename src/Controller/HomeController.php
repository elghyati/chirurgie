<?php

namespace App\Controller;

use App\Entity\ArrivalSetting;
use App\Repository\ArrivalRepository;
use App\Repository\ArrivalSettingRepository;
use App\Repository\MiddleSlideRepository;
use App\Repository\PromotionRepository;
use App\Repository\SluganRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\Cart\CartService;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home_index")
     */
    public function index(SessionInterface         $session, CartService $cartService,
                          MiddleSlideRepository    $middleSlideRepository,
                          ArrivalRepository        $arrivalRepository,
                          PromotionRepository      $promotionRepository,
                          ArrivalSettingRepository $settingRepository,
                          SluganRepository         $sluganRepository
    )
    {
        $middles = $middleSlideRepository->findByDisplay(true);
        $arrivals = $arrivalRepository->findByDisplay(true);
        $settingarrival = $settingRepository->findByDisplay(true);
        $promotions = $promotionRepository->findByDisplay(true);
        $slugans = $sluganRepository->findAll();
//        dd($settingarrival);
        return $this->render('home/index.html.twig', [
            'middles' => $middles,
            'arrivals' => $arrivals,
            'arrivalsetting' => $settingarrival,
            'promotions' => $promotions,
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal()
        ]);
    }
}
