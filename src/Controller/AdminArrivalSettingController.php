<?php

namespace App\Controller;

use App\Entity\ArrivalSetting;
use App\Form\AdminArrivalSettingType;
use App\Repository\ArrivalSettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/arrivagesetting")
 */
class AdminArrivalSettingController extends AbstractController
{
    /**
     * @Route("/", name="admin_arrivagesetting_index")
     */
    public function index(ArrivalSettingRepository $settingRepository)
    {
        $settings = $settingRepository->findAll();
        return $this->render('admin/arrivage_setting/index.html.twig', [
            'settings' => $settings,
        ]);
    }

    /**
     * @Route("/new", name="admin_arrivagesetting_new", methods={"GET","POST"})
     */
    public function new(Request $request, ArrivalSettingRepository $settingRepository): Response
    {
        $setting = new ArrivalSetting();
        $form = $this->createForm(AdminArrivalSettingType::class, $setting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updtDisplay($settingRepository);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($setting);
            $entityManager->flush();

            return $this->redirectToRoute('admin_arrivagesetting_index');
        }

        return $this->render('admin/arrivage_setting/new.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_arrivagesetting_show", methods={"GET"})
     */
    public function show(ArrivalSetting $setting): Response
    {
        return $this->render('admin/arrivage_setting/show.html.twig', [
            'setting' => $setting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_arrivagesetting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArrivalSetting $setting, ArrivalSettingRepository $settingRepository): Response
    {
        $form = $this->createForm(AdminArrivalSettingType::class, $setting);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Mise à jour l'etat d'affichage des titres
//            dd($setting->getDisplay());
            if ($setting->getDisplay() == true) {
                $this->updtDisplay($settingRepository);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_arrivagesetting_index');
        }

        return $this->render('admin/arrivage_setting/edit.html.twig', [
            'setting' => $setting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_arrivagesetting_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArrivalSetting $settings, ArrivalSettingRepository $settingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $settings->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($settings);
            $entityManager->flush();
            if ($settings->getDisplay() == true) {
                $this->activDisplay($settingRepository);
            }

        }

        return $this->redirectToRoute('admin_arrivagesetting_index');
    }


    //Mise à jour l'etat d'affichage des titres
    public function updtDisplay(ArrivalSettingRepository $settingRepository)
    {
        $settings = $settingRepository->findByDisplay(true);

        foreach ($settings as $sett) {
            $sett->setDisplay(false);
            $this->getDoctrine()->getManager()->persist($sett);
            $this->getDoctrine()->getManager()->flush();
        }

    }

    public function activDisplay(ArrivalSettingRepository $settingRepository)
    {
        $results = ($settingRepository->findOneBy([], ['id' => 'DESC']));
        if (!empty($results)) {
            $results->setDisplay(true);
            $this->getDoctrine()->getManager()->persist($results);
            $this->getDoctrine()->getManager()->flush();
        }
    }


}
