<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\Customer;
use App\Form\AccountType;
use App\Form\CustomerType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/account")
 */
class AccountController extends AbstractController {

    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils) {
        $error = $utils->getLastAuthenticationError();
        $customername = $utils->getLastUsername();
//        dump($error);
        return $this->render('account/login.html.twig', [
                    'hasError' => $error !== null,
                    'customername' => $customername
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout() {
        //Le rendu est défini dans Security.yaml
    }

    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder) {

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($customer, $customer->getHash());
            $customer->setHash($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();
            $this->addFlash("success", "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter ! ");
            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile(Request $request, ObjectManager $manager) {
        $customer = $this->getCustomer();
        $form = $this->createForm(AccountType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($customer);
            $manager->flush();
            $this->addFlash("success", "Votre profile a bien été modifié !");
        }
        return $this->render('account/profile.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     */
    public function updatePassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $passwordUpdate = new PasswordUpdate();
        $customer = $this->getCustomer();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdate->getOldPassword(), $customer->getHash())) {
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé n'est pas votre mot de passe actuel !"));
            } else {
                $hash = $encoder->encodePassword($customer, $passwordUpdate->getNewPassword());
                $customer->setHash($hash);
                $manager->persist($customer);
                $manager->flush();
                $this->addFlash("success", "Votre mot de passe a bien été modifié !");
                return $this->redirectToRoute('account_logout');
            }
        }
        return $this->render('account/password.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * 
     * @return Response
     */
    function MyAccount() {
        return $this->render('customer/index.html.twig', ['customer' => $this->getCustomer()]);
    }

//    /**
//     * @Route("/account/bookings", name="account_bookings")
//     * @IsGranted("ROLE_USER")
//     * 
//     * @return Response
//     */
//    function bookings() {
//        return $this->render('account/bookings.html.twig');
//    }
}
