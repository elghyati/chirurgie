<?php

namespace App\Form;

use App\Entity\PasswordUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Form\ApplicationType;
 

class PasswordUpdateType extends  ApplicationType{

    /**
     * 
     * @param string $label 
     * @param string $placeholder 
     * @param array $options
     * @return array  
     */
    public function getConfiguration($label, $placeholder, $options = []) {
        return array_merge([
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
                ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien Mot de passe", "Votre ancien mot de passe..."))
                ->add('newPassword', PasswordType::class, $this->getConfiguration("Nouveau Mot de passe", "Votre nouveau mot de passe..."))
                ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmation du nouveau mot de passe", "Confirmez votre nouveau mot de passe..."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => PasswordUpdate::class,
        ]);
    }

}
