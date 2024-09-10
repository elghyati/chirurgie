<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Color;
use App\Entity\Size;
use App\Entity\Variant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariantType extends ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('reference', TextType::class, $this->getConfiguration("Référence", "Référence..."))
                ->add('size', EntityType::class, $this->getConfiguration("Taille", "Tallie...",
                                ['class' => Size::class, 'choice_label' => 'size',]
                        ))
                ->add('color', EntityType::class, $this->getConfiguration("Couleur", "Couleur...",
                                ['class' => Color::class, 'choice_label' => 'name',]
                        ))
                ->add('price', NumberType::class, $this->getConfiguration("Prix", "Prix..."))
                ->add('priceProfessional', TextType::class, $this->getConfiguration("Prix Professionnel", "Prix Professionnel..."))
                ->add('priceDealer', TextType::class, $this->getConfiguration("Prix Revendeur", "Prix Revendeur..."))
                ->add('brand', EntityType::class, $this->getConfiguration("Marque", "Marque...",
                                ['class' => Brand::class, 'choice_label' => 'libelle', 'placeholder' => 'Marque...', 'required' => false,]
                        ))
                ->add('discount', PercentType::class, $this->getConfiguration("Remise", "Remise...",
                                ['data' => 0,]
                        ))
//                ->add('stock', CheckboxType::class, $this->getConfiguration("En stock", "En stock..."))
                ->add('stock', CheckboxType::class, $this->getConfiguration(" ", " ", ['required' => false,]))
                ->add('images', CollectionType::class, $this->getConfiguration("Images supplémentaires", "", [
                            'entry_type' => AdminImageType::class,
                            'allow_add' => true,
                            'allow_delete' => true,
//                    'by_reference' => false,
                ]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Variant::class,
        ]);
    }

}
