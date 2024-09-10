<?php

namespace App\Form;

use App\Entity\SousFamille;
use App\Entity\Famille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ApplicationType;


class SousFamilleType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sousFamille')
            ->add('norder')
//                ->add('Famille')
            ->add('Famille', EntityType::class, [
                // looks for choices from this entity
                'class' => Famille::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'famille',
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('norder', IntegerType::class, $this->getConfiguration("N°ordre", "N°", ['required' => false]))
            ->add('enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousFamille::class,
        ]);
    }

}
