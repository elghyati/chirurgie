<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\AdminCustomerEditType;
use App\Form\AdminCustomerType;
use App\Form\AdminPasswordUpdateType;
use App\Repository\CustomerRepository;
use App\Repository\RoleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function dump;

/**
 * @Route("/admin/customer")
 */
class AdminCustomerController extends AbstractController {

    /**
     * @Route("/", name="admin_customer_index", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository): Response {
//        dd($customerRepository->findAll());
        return $this->render('admin/customer/index.html.twig', [
                    'customers' => $customerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_customer_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, RoleRepository $roleRepository): Response {
        $customer = new Customer();
        $form = $this->createForm(AdminCustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            dd($customer);
            $hash = $encoder->encodePassword($customer, $customer->getHash());
            $customer->setHash($hash);
            $role = $roleRepository->find(2);
            dump($role);
            $customer->addUserRole($role);      //ROLE_CUSTOMER
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/new.html.twig', [
                    'customer' => $customer,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_customer_show", methods={"GET"})
     */
    public function show(Customer $customer): Response {
        return $this->render('admin/customer/show.html.twig', [
                    'customer' => $customer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_customer_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Customer $customer): Response {
        $form = $this->createForm(AdminCustomerEditType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_customer_index');
        }

        return $this->render('admin/customer/edit.html.twig', [
                    'customer' => $customer,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_customer_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Customer $customer): Response {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_customer_index');
    }

    /**
     * @Route("/password-update", name="admin_customer_password")
     */
    public function updatePassword(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $passwordUpdate = new PasswordUpdate();
        $customer = $this->getCustomer();
        $form = $this->createForm(AdminPasswordUpdateType::class, $passwordUpdate);
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
        return $this->render('account/password.html.twig', [
                    'form' => $form->createView()
        ]);
    }

}
