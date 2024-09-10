<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use \App\Form\RegistrationType;
use \App\Entity\PasswordUpdate;
use App\Form\PasswordUpdateType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \App\Form\ProfileType;
use \Doctrine\Common\Persistence\ObjectManager;
use \Symfony\Component\Form\FormError;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/account")
 */
class UserController extends AbstractController {

    /**
     * @Route("/", name="user_index")
     * 
     * @return Response
     */
    public function index() {
        return $this->render('user/index.html.twig', [
                    'controller_name' => 'UserController',
        ]);
    }
//
//    /**
//     * @Route("/login", name="user_login")
//     * 
//     * @return Response
//     */
//    public function login(AuthenticationUtils $utils) {
//        $error = $utils->getLastAuthenticationError();
//        $username = $utils->getLastUsername();
////        dump($error);
//        return $this->render('user/login.html.twig', [
//                    'hasError' => $error !== null,
//                    'username' => $username
//        ]);
//    }
//
//    /**
//     * @Route("/logout", name="user_logout")
//     * 
//     * @return void
//     */
//    public function logout() {
//        return $this->render('user/login.html.twig');
//    }

    /**
     * @Route("/register", name="user_register")
     * 
     * @return void
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder) {
        $user = new User;
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été bien été créé ! Vous pouvez maintenant vous connecter !');
            return $this->redirectToRoute('user_login');
        }
        return $this->render('user/registeration.html.twig', [
                    'formUser' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile", name="user_profile")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager) {
        $user = $this->getUser();
        $oldUser = $user;
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setEmail($oldUser->getEmail());
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre profil a été bien été modifié !');
//            return $this->redirectToRoute('user_login');
        }
        return $this->render('user/profile.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/update-password", name="user_password")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                dump($passwordUpdate);
                dump($user);
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Votre mot de passe a été bien été modifié !');
                return $this->redirectToRoute('home_index');
            }
//            $user = $form->getData();
//            $user->setEmail($oldUser->getEmail());
//            $manager->persist($user);
//            $manager->flush();
//            $this->addFlash('success', 'Votre profil a été bien été modifié !');
        }
        return $this->render('user/password.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
