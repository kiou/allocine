<?php

namespace App\Form\Film;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Film\Film;
use App\Entity\Film\Categorie;
use App\Entity\Personne\Personne;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\LangueType;
use App\Form\Referencement\ReferencementType;
use App\Form\EventListener\SousCategorieFieldListener;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('slug', TextType::class)
            ->add('synopsis', TextareaType::class)
            ->add('ba', TextareaType::class)
            ->add('acteurs', EntityType::class, array(
                'multiple' => true,
                'class' => Personne::class,
                'choice_label' => function ($personne) {
                    return $personne->displayNameForm();
                },
                'placeholder' => 'Choisir un acteur'
                )
            )
            ->add('realisateurs', EntityType::class, array(
                'multiple' => true,
                'class' => Personne::class,
                'choice_label' => function ($personne) {
                    return $personne->displayNameForm();
                },
                'placeholder' => 'Choisir un réalisateur'
                )
            )
            ->add('categorie', EntityType::class, array(
                'class' => Categorie::class,
                'choice_label' => 'titre',
                'placeholder' => 'Choisir une catégorie'
                )
            )
            ->addEventSubscriber(new SousCategorieFieldListener())
            ->add('datedesortie', DateType::class, array(
                    'attr' => array(
                        'placeholder' => '00/00/0000'
                    ),
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy'
                )
            )
            ->add('fileimage', FileType::class)
            ->add('referencement', ReferencementType::class)
            ->add('langue', LangueType::class)
            ->add('Enregistrer', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class
        ]);
    }
}
