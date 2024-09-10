<?php

namespace App\Form;

use App\Entity\Arrival;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminArrivalType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Image...", ['required' => false]))

            ->add('position', ChoiceType::class, $this->getConfiguration("Position", "left/right...", [
                'choices' => ['Left' => 'Left','Right' => 'Right'],
                'required' => true,
                'expanded' => true,
                'multiple' => false
            ]))
            ->add('display', CheckboxType::class, $this->getConfiguration("Afficher ", " ", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Arrival::class,
        ]);
    }
}
