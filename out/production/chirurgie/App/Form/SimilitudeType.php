<?php

namespace App\Form;

use App\Entity\Famille;
use App\Entity\Similitude;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ApplicationType;
 

class SimilitudeType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('Similitude')
                ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Similitude::class,
        ]);
    }

}
