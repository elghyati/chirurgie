<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\ApplicationType;
 
class CommandeType extends  ApplicationType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('date', DateType::class, [
//                    'widget' => 'choice',
                    "widget" => "single_text",
                ])
                ->add('status')
//                ->add('dateValidation')
                ->add('dateValidation', DateType::class, [
//                    'widget' => 'choice',
                    "widget" => "single_text",
                ])
//                ->add('client')
                ->add('Client', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Client::class,
                    // uses the User.username property as the visible option string
//                    'choice_label' => 'nom' ,
                    'choice_label' => function (?Client $client) {
                        return $client ? $client->getFullName() : '';
                    },
                        // used to render a select box, check boxes or radios
                        // 'multiple' => true,
                        // 'expanded' => true,
                ])
                ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }

}
