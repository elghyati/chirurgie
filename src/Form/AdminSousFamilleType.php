<?php

namespace App\Form;

use App\Entity\Famille;
use App\Entity\SousFamille;
use App\Form\ApplicationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSousFamilleType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('sousFamille', TextType::class, $this->getConfiguration("Sous-famille", "Sous-famille..."))
//                ->add('coverImage')
                ->add('imageFile', FileType::class, $this->getConfiguration("Image", "Image de la sous-famille...", ['required' => false]))
                ->add('famille', EntityType::class,
                        $this->getConfiguration("Famille", "Famille...", ['class' => Famille::class, 'choice_label' => 'Famille',
                                // 'multiple' => true,
                                // 'expanded' => true,
                ]))
            ->add('norder', IntegerType::class, $this->getConfiguration("N°ordre", "N°", ['required' => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => SousFamille::class,
        ]);
    }

}
