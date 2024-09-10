<?php

namespace App\Form;

use App\Entity\Size;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use \App\Form\ApplicationType;

class AdminSizeType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('size', TextType::class, $this->getConfiguration("Taille", "Taille..."))
//            ->add('articles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Size::class,
        ]);
    }

}
