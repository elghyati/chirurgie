<?php

namespace App\Form;

use App\Entity\OrderDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminOrderDetailType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('price')
                ->add('quantity')
                ->add('subTotal')
                ->add('sequence')
                ->add('article')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => OrderDetail::class,
        ]);
    }

}
