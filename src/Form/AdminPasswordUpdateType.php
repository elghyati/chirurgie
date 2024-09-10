<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminPasswordUpdateType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien mot de passe", "Ancien mot de passe..."))
                ->add('newPassword', PasswordType::class, $this->getConfiguration("Nouveau mot de passe", "Nouveau mot de passe..."))
                ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmation de nouveau mot de passe", "Confirmer le nouveau mot de passe..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                // Configure your form options here
        ]);
    }

}
