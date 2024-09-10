<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Size;
use App\Form\ApplicationType;
use App\Form\ImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminArticleType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('reference', TextType::class, $this->getConfiguration("Référence", "Référence de l'article ..."))
                ->add('designation', TextType::class, $this->getConfiguration("Désignation", "Désignation..."))
                ->add('description', TextareaType::class, $this->getConfiguration("Déscription", "Déscription...", ['required' => false]))
//            ->add('coverImage')
                ->add('imageFile', FileType::class, $this->getConfiguration("Image principale", "Image principale...", ['required' => false]))
                ->add('price', TextType::class, $this->getConfiguration("Prix Particulier", "Prix Particulier..."))
                ->add('priceProfessional', TextType::class, $this->getConfiguration("Prix Professionnel", "Prix Professionnel..."))
                ->add('priceDealer', TextType::class, $this->getConfiguration("Prix Revendeur", "Prix Revendeur..."))
//            ->add('updatedAt')
                ->add('sousFamille', null, $this->getConfiguration("Sous Famille", "Sous Famille..."))
//            ->add('relatedTo')
//            ->add('articles')
//                ->add('sizes', null, $this->getConfiguration("Tailles", "Tailles..."))
//                ->add('articleSizes', null, $this->getConfiguration("Tailles", "Tailles..."))
//                ->add('sizes', CollectionType::class, $this->getConfiguration("Tailles", "Tailles...", [
//                            'entry_type' => \App\Form\AdminArticleSizeType::class,
//                            'allow_add' => true,
//                            'allow_delete' => true,
//                ]))
//                ->add('images')
                ->add('images', CollectionType::class, $this->getConfiguration("Images supplémentaires", "", [
                            'entry_type' => \App\Form\AdminImageType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
//                    'by_reference' => false,
                ]))
                ->add('variants', CollectionType::class, $this->getConfiguration("Variantes", "Variantes...", [
                            'entry_type' => \App\Form\VariantType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
//                    'by_reference' => false,
                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }

}
