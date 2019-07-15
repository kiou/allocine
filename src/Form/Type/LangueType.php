<?php

namespace App\Form\Type;

use App\Entity\General\Langue;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\DataTransformer\LangueTransformer;

class LangueType extends AbstractType{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new LangueTransformer($this->manager), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'class' => Langue::class,
            'choice_value' => 'code',
            'choice_label' => 'nom'
        ));
    }

    public function getParent()
    {
        return EntityType::class;
    }

}

?>