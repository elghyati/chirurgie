<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, $this->getConfiguration("Nom  ", "Nom ", ['required' => true]))
            ->add('lastname',TextType::class, $this->getConfiguration("Prenom  ", "Prenom ", ['required' => true]))
            ->add('phone',TextType::class, $this->getConfiguration("Gsm  ", "Gsm ", ['required' => true]))
            ->add('email',EmailType::class, $this->getConfiguration("Email  ", "Email ", ['required' => true]))
            ->add('message',TextareaType::class, $this->getConfiguration("Message  ", "Message ", ['required' => true]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Contact::class
        ]);
    }
}
