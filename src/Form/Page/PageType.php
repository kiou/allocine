<?php

namespace App\Form\Page;

use App\Entity\Page\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Type\LangueType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Referencement\ReferencementType;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre', TextType::class)
                ->add('slug', TextType::class)
                ->add('contenu', TextareaType::class)
                ->add('referencement', ReferencementType::class)
                ->add('langue', LangueType::class)
                ->add('Enregistrer', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Page::class
        ));
    }

}
