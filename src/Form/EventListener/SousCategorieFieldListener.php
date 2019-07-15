<?php

namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Film\SousCategorie;
use Doctrine\ORM\EntityRepository;

class SousCategorieFieldListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT   => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $categorie  = $data->getCategorie();

        $form->add('souscategorie', EntityType::class, array(
            'class' => SousCategorie::class,
            'query_builder' => function (EntityRepository $er) use($categorie) {
                return $er->getByCategorie($categorie, true);
            },
            'choice_label' => 'titre',
            'placeholder' => 'Choisir une sous catégorie'
            )
        );
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();
        $categorie = $data['categorie'];
        
        $form->add('souscategorie', EntityType::class, array(
            'class' => SousCategorie::class,
            'query_builder' => function (EntityRepository $er) use($categorie) {
                return $er->getByCategorie($categorie, true);
            },
            'choice_label' => 'titre',
            'placeholder' => 'Choisir une sous catégorie'
            )
        );
    }

}


?>