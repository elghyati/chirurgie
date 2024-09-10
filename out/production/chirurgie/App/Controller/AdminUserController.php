<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminAccountType;
use App\Form\AdminPasswordUpdateType;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user")
 */
class AdminUserController extends AbstractController {

    /**
     * @Route("/", name="admin_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response {
        return $this->render('admin/user/index.html.twig', [
                    'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $user = new User();
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response {
        return $this->render('admin/user/show.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response {
        $form = $this->createForm(AdminAccountType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/password-update", name="admin_user_password")
     */
    public function updatePassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(AdminPasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getHash())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $hash = $encoder->encodePassword($user, $passwordUpdate->getNewPassword());
                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash("success", "Votre mot de passe a bien été modifié !");
                return $this->redirectToRoute('account_logout');
            }
        }
        return $this->render('account/password.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
