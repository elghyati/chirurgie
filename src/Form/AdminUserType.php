<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('civilite', ChoiceType::class, $this->getConfiguration("Civilité", "Civilité...",
                                array('choices' => array('Mme' => 'Mme', 'Mr' => 'Mr'),
                                    'required' => true,
                                    'expanded' => true,
                                    'multiple' => false
                        ))
//                        , ChoiceType::class, $this->getConfiguration("Civilité", "Civilité...", array(
//                            'choices' => array('Mr' => 'Mr', 'Mme' => 'Mme'),
//                            'required' => true,
//                            'expanded' => true,
//                            'multiple' => false
//                )
                )
                ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Nom..."))
                ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Prénom..."))
                ->add('email', TextType::class, $this->getConfiguration("E-mail", "E-mail..."))
//                ->add('picture', TextType::class, $this->getConfiguration("Avatar", "Avatar..."))
                ->add('imageFile', FileType::class, $this->getConfiguration("Image principale", "Image principale...", ['required' => false]))
                ->add('hash', PasswordType::class, $this->getConfiguration("Password", "Mot de passe..."))
                ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de password", "Confirmer le mot de passe..."))
                ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "..."))
//                ->add('slug')
                ->add('job', TextType::class, $this->getConfiguration("Profession", "Profession..."))
                ->add('company', TextType::class, $this->getConfiguration("Société", "Société..."))
                ->add('adresse', TextType::class, $this->getConfiguration("Adresse", "Adresse..."))
                ->add('ville', TextType::class, $this->getConfiguration("Ville", "Ville..."))
                ->add('codePostal', TextType::class, $this->getConfiguration("Code postal", "Code postal..."))
                ->add('enabled', null, $this->getConfiguration("Actif", "Actif", ['attr' => ['class' => 'text-editor']]))
                ->add('tel', TextType::class, $this->getConfiguration("Tél", "Tél..."))
                ->add('gsm', TextType::class, $this->getConfiguration("GSM", "GSM..."))
                ->add('userRoles', null, $this->getConfiguration("Rôles", "Rôles..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
