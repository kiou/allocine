<?php

namespace App\Form\Diaporama;

use App\Entity\Diaporama\Galerie;
use App\Entity\Diaporama\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Referencement\ReferencementType;
use App\Form\Type\LangueType;
use App\Entity\Film\Film;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GalerieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('slug', TextType::class)
            ->add('fileimage', FileType::class)
            ->add('categorie', EntityType::class, array(
                    'class' => Categorie::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir une catégorie'
                )
            )
            ->add('filmgalerie', EntityType::class, array(
                    'class' => Film::class,
                    'choice_label' => 'titre',
                    'placeholder' => 'Choisir un film'
                )
            )
            ->add('resume', TextareaType::class)
            ->add('contenu', TextareaType::class)
            ->add('referencement', ReferencementType::class)
            ->add('langue', LangueType::class)
            ->add('Enregistrer', SubmitType::class, array(
                    'attr' => array('class' => 'form-submit turquoise medium')
                )
            );
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Galerie::class
        ));
    }

}
