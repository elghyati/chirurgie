<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('civilite', TextType::class, $this->getConfig("Civilité", "Civilité : Mr ou Mme"))
                ->add('firstName', TextType::class, $this->getConfig("Prénom", "Prénom..."))
                ->add('lastName', TextType::class, $this->getConfig("Nom", "Nom de famille"))
                ->add('email', TextType::class, $this->getConfig("Email", "Email..."))
//                ->add('slug', TextType::class, $this->getConfig("Slug", "Slug..."))
                ->add('job', TextType::class, $this->getConfig("Profession", "Profession..."))
                ->add('adresse', TextType::class, $this->getConfig("Adresse", "Adresse..."))
                ->add('codePostal', TextType::class, $this->getConfig("Code postal", "Code postal..."))
                ->add('ville', TextType::class, $this->getConfig("Ville", "Ville..."))
//                ->add('password', PasswordType::class, $this->getConfig("Password", "Password..."))
//                ->add('userRoles', TextType::class, $this->getConfig("Rôles", "Rôles..."))
                ->add('enregistrer', SubmitType::class, $this->getConfig("Enregistrer le profil", ""))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
