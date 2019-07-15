<?php

namespace App\Form\Page;

use App\Entity\Page\Menu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\Type\LangueType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MenuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('lien', TextType::class)
            ->add('destination', ChoiceType::class,array(
                    'choices' => array(
                        'Interne' => true,
                        'Externe' => false
                    ),
                    'expanded' => true
                )
            )
            ->add('langue', LangueType::class)
            ->add('Enregistrer', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Menu::class
        ));
    }


}
