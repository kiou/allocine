<?php

namespace App\Form\Evenement;

use App\Entity\Evenement\Categorie;
use App\Entity\Evenement\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\Type\LangueType;
use App\Form\Referencement\ReferencementType;

class EvenementType extends AbstractType
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
            ->add('debut', DateType::class, array(
                    'attr' => array(
                        'placeholder' => '00/00/000 00:00'
                    ),
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy HH:mm'
                )
            )
            ->add('fin', DateType::class, array(
                    'attr' => array(
                        'placeholder' => '00/00/000 00:00'
                    ),
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'dd/MM/yyyy HH:mm'
                )
            )
            ->add('fileimage', FileType::class)
            ->add('categorie', EntityType::class, array(
                    'class' => Categorie::class,
                    'choice_label' => 'nom',
                    'placeholder' => 'Choisir une catégorie'
                )
            )
            ->add('avant', ChoiceType::class,array(
                    'choices' => array(
                        'Oui' => true,
                        'Non' => False
                    ),
                    'expanded' => true
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
            'data_class' => Evenement::class
        ));
    }

}
