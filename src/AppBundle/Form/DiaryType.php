<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiaryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('users', EntityType::class, [
                'class'         => 'AppBundle\Entity\Users',
                'placeholder'   => 'Séléctionnez un utilisateur',
                'mapped'        => true,
                'required'      => true
            ])
            ->add('categorie', ChoiceType::class, [
                'placeholder'   => 'Séléctionnez une catégorie',
                'attr'          => array(
                    'class'     => 'list_categorie'
                ),
                'required'      => true
            ])
            ->add('langue', EntityType::class, [
                'class'         => 'AppBundle\Entity\Langue',
                'placeholder'   => 'Séléctionnez une langue',
                'mapped'        => true,
                'required'      => true
            ])
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('date_debut', DateType::class, [
                'label'  =>'date début',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker date_debut'],
                'placeholder' => 'Select a value'
            ])
            ->add('date_fin', DateType::class, [
                'label'  =>'date fin',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                // add a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker date_fin'],
                'placeholder' => 'Select a value'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Diary'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_diary';
    }


}
