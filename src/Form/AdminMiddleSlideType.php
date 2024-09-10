<?php

namespace App\Form;

use App\Entity\MiddleSlide;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminMiddleSlideType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Image...", ['required' => false]))
            ->add('display', CheckboxType::class, $this->getConfiguration("Afficher ", " ", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MiddleSlide::class,
        ]);
    }
}
