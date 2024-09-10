<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminOrderType extends \App\Form\ApplicationType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//            ->add('createdAt')
//            ->add('updatedAt')
                ->add('amount')
                ->add('status', EntityType::class, $this->getConfiguration("Statut", "Statut...", ['class' => OrderStatus::class, 'choice_label' => 'libstatus',]))
                ->add('customer', EntityType::class, $this->getConfiguration("Client", "Client...", ['class' => Customer::class, 'choice_label' => 'fullName',]))
                ->add('updatedBy', EntityType::class, $this->getConfiguration("Utilisateur", "Utilisateur...", ['class' => User::class, 'choice_label' => 'fullName',]))
                ->add('orderDetails', CollectionType::class,
                        $this->getConfiguration("Details de la commande", "Details...",
                                [
                                    'entry_type' => \App\Form\AdminOrderDetailType::class,
                                    'allow_add' => true,
                                    'allow_delete' => true,
                        ])
                )
//            ->add('createdAt' | date('d/m/Y H:i:s'))
//                ->add('updatedAt' | date('d/m/Y H:i:s'))
//                ->add('amount')
//                ->add('status')
//                ->add('customer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }

}
