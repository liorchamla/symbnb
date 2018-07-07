<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdminAdType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', "Titre de l'annonce"))
            ->add('slug', TextType::class, $this->getConfiguration('Slug', "URL simplifiée (automatique)"))
            ->add('introduction', TextareaType::class, $this->getConfiguration('Introduction', "Introduction pour l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration('Description', "Description de l'annonce"))
            ->add('coverImage', UrlType::class, $this->getConfiguration('Image de couverture', "URL de l'image de couverture"))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit', "Prix par nuit"))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Chambres', "Nombre de chambres"))
            ->add('owner', EntityType::class, $this->getConfiguration('Propriétaire', '', ['class' => User::class, 'choice_label' => function($user) {
                return $user->getFirstName() . ' ' . $user->getLastName();
            }]))
            ->add('images', CollectionType::class, $this->getConfiguration('Autres images', '', ['entry_type' => ImageType::class, 'entry_options' => ['label' => false], 'allow_delete' => true, 'by_reference' => false]))
            ->add('save', SubmitType::class, ['label' => "Enregistrer les modifications", 'attr' => ['class' => "btn btn-primary"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
