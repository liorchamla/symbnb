<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, $this->getConfiguration('Adresse email', 'Votre adresse email ...'))
            ->add('firstName', TextType::class, $this->getConfiguration('Prénom', 'Votre prénom ...'))
            ->add('lastName', TextType::class, $this->getConfiguration('Nom de famille', 'Votre nom de famille ...'))
            ->add('picture', UrlType::class, $this->getConfiguration('Avatar', 'URL de votre avatar ...'))
            ->add('description', TextareaType::class, $this->getConfiguration('Description', 'Décrivez vous avec vos propres mots !'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
