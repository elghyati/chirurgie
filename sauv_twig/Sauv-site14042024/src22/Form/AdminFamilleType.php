<?php

namespace App\Form;

use App\Entity\Famille;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminFamilleType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('famille', TextType::class, $this->getConfiguration("Famille", "Famille..."))
//                ->add('coverImage')
                ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Image de la famille...", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Famille::class,
        ]);
    }

}
