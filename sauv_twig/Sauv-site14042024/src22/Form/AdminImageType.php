<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('url')
//                ->add('url', FileType::class, array('data_class' => null, 'required' => false, 'multiple' => false, 'attr' => array('accept' => ".jpg, .jpeg, .png")))
                ->add('imageFile', FileType::class, [
//                    'data_class' => null,
                    'required' => false,
                    'multiple' => false,
                    'attr' => array('accept' => ".jpg, .jpeg, .png")
                ])
                ->add('caption')
//            ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }

}
