<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => "Titre de l'annonce", 'attr' => [
                'placeholder' => "Tappez le titre de l'annonce !"
            ]])
            ->add('slug', TextType::class, ['label' => "Chemin d'URL (optionnel)", 'required' => false, 'attr' => [
                'placeholder' => "Précisez vous-même ou laissez le système le faire !"
            ]])
            ->add('introduction', TextareaType::class, ['label' => "Introduction", 'attr' => [
                'placeholder' => "Tappez une introduction pour le bien concerné !"
            ]])
            ->add('content', TextareaType::class, ['label' => "Description détaillée", 'required' => false, 'attr' => [
                'placeholder' => "C'est le moment de vendre votre bien ! Racontez nous tout !"
            ]])
            ->add('coverImage', UrlType::class, ['label' => "Image principale", 'attr' => [
                'placeholder' => "URL vers l'image principale !"
            ]])
            ->add('price', MoneyType::class, ['label' => "Prix par nuit", 'attr' => [
                'placeholder' => "Prix par nuit pour votre annonce"
                ]])
            ->add('rooms', NumberType::class, ['label' => "Nombre de chambres", 'attr' => [
                    'placeholder' => "Nombre de chambres disponibles"
                    ]])
            ->add('images', CollectionType::class, ['label' => "Autres images", 'entry_type' => UrlType::class, 'entry_options' => [
                'label_attr' => [
                    'style' => 'display:none;'
                ],
                'attr' => [
                    'placeholder' => "URL d'une image complémentaire"
                ]
                ], 'allow_add' => true, 'allow_delete' => true, 'delete_empty' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
