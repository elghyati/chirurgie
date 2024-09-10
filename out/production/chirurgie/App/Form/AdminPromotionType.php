<?php

namespace App\Form;

use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminPromotionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom", "Nom", ['required' => true]))
            ->add('description', TextType::class, $this->getConfiguration("description", "description", ['required' => true]))
            ->add('percentage', TextType::class, $this->getConfiguration("Remise%", "Remise%", ['required' => true]))
            ->add('display', CheckboxType::class, $this->getConfiguration("Afficher ", " ", ['required' => false]))
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Image...", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
