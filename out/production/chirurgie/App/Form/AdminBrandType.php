<?php

namespace App\Form;

use App\Entity\Famille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminBrandType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('libelle', TextType::class, $this->getConfiguration("Marque", "Marque..."))
//                ->add('logo')
                ->add('imageFile', FileType::class, $this->getConfiguration("Logo", "Logo de la marque...", ['required' => false]))
                ->add('famille', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Famille::class,
                    // uses the User.username property as the visible option string
                    'choice_label' => 'famille',
                        // used to render a select box, check boxes or radios
                        // 'multiple' => true,
                        // 'expanded' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
                // Configure your form options here
        ]);
    }

}
