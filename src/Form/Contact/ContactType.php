<?php

namespace App\Form\Contact;

use App\Entity\Contact\Contact;
use App\Entity\Contact\Objet;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType

{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('langue', HiddenType::class)
            ->add('objet', EntityType::class, array(
                    'class' => Objet::class,
                    'query_builder' => function(EntityRepository $er) use($options){
                        return $er->getAllObjets($options['langue'], true);
                    },
                    'choice_label' => 'nom',
                    'placeholder' => 'contact.label.objetall'
                )
            )
            ->add('message', TextareaType::class)
            ->add('Enregistrer', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
            'langue' => null
        ));
    }

}
