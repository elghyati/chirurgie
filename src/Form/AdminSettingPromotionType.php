<?php

namespace App\Form;

use App\Entity\PromotionSetting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSettingPromotionType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre Afficher", "Titre Afficher", ['required' => true]))
            ->add('display',CheckboxType::class, $this->getConfiguration("Afficher ", " ", ['required' => false]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromotionSetting::class,
        ]);
    }
}
