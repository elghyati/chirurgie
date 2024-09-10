<?php

namespace App\Controller;

use App\Entity\PromotionSetting;
use App\Form\AdminSettingPromotionType;
use App\Repository\PromotionSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/promotionsetting")
 */
class AdminPromotionSettingController extends AbstractController
{
    /**
     * @Route("/", name="admin_promotionsetting_index")
     */
    public function index(PromotionSettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        return $this->render('admin/promotion_setting/index.html.twig', [
            'settings' => $settings,
        ]);
    }

    /**
     * @Route("/new", name="admin_promotionsetting_new", methods={"GET","POST"})
     */
    public function new(Request $request, PromotionSettingRepository $settingRepository): Response
    {
        $setting = new PromotionSetting();
        $form = $this->createForm(AdminSettingPromotionType::class, $setting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updtDisplay($settingRepository);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($setting);
            $entityManager->flush();

            return $this->redirectToRoute('admin_promotionsetting_index');
        }

        return $this->render('admin/promotion_setting/new.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotionsetting_show", methods={"GET"})
     */
    public function show(PromotionSetting $setting): Response
    {
        return $this->render('admin/promotion_setting/show.html.twig', [
            'setting' => $setting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_promotionsetting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PromotionSetting $setting, PromotionSettingRepository $settingRepository): Response
    {
        $form = $this->createForm(AdminSettingPromotionType::class, $setting);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Mise à jour l'etat d'affichage des titres
            dd($setting->getDisplay());
            if ($setting->getDisplay() == true) {
                $this->updtDisplay($settingRepository);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_promotionsetting_index');
        }

        return $this->render('admin/promotion_setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotionsetting_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PromotionSetting $setting, PromotionSettingRepository $settingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $setting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($setting);
            $entityManager->flush();
            if ($setting->getDisplay() == true) {
                $this->activDisplay($settingRepository);
            }

        }

        return $this->redirectToRoute('admin_promotionsetting_index');
    }


    //Mise à jour l'etat d'affichage des titres
    public function updtDisplay(PromotionSettingRepository $settingRepository)
    {
        $settings = $settingRepository->findByDisplay(true);

        foreach ($settings as $sett) {
            $sett->setDisplay(false);
            $this->getDoctrine()->getManager()->persist($sett);
            $this->getDoctrine()->getManager()->flush();
        }

    }

    public function activDisplay(PromotionSettingRepository $settingRepository)
    {
        $results = ($settingRepository->findOneBy([], ['id' => 'DESC']));
        if (!empty($results)) {
            $results->setDisplay(true);
            $this->getDoctrine()->getManager()->persist($results);
            $this->getDoctrine()->getManager()->flush();
        }
    }


}
