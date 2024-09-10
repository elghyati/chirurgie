<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Similitude;
use App\Entity\SousFamille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\ApplicationType;

class ArticleType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('reference', TextType::class, $this->getConfig("Référence", "Référence de l'article"))
                ->add('designation', TextType::class, $this->getConfig("Désignation", "Désignation de l'article"))
                ->add('image', FileType::class)
                ->add('puht', TextType::class, $this->getConfig("Prix unitaire HT", "Prix unitaire de l'article"))
                ->add('sousFamille', EntityType::class,
                        $this->getConfig("Sous Famille", "Sous famille de l'article",
                                [
                                    // looks for choices from this entity
                                    'class' => SousFamille::class,
                                    // uses the User.username property as the visible option string
                                    'choice_label' => 'sousFamille',
                                // used to render a select box, check boxes or radios
                                // 'multiple' => true,
                                // 'expanded' => true,
                ]))
                ->add('Similitude', EntityType::class,
                        $this->getConfig("Similitude", "Similitude de l'article",
                                [
                                    // looks for choices from this entity
                                    'class' => Similitude::class,
                                    // uses the User.username property as the visible option string
                                    'choice_label' => 'similitude',
                                // used to render a select box, check boxes or radios
                                // 'multiple' => true,
                                // 'expanded' => true,
                ]))
                ->add('enregistrer', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
