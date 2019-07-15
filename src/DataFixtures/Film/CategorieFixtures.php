<?php

namespace App\DataFixtures\Film;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Film\Categorie;

class CategorieFixtures extends Fixture
{

	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadCategories($manager);
    }

    public function loadCategories(ObjectManager $manager)
    {

        $categories = ['Polar','Drame','Thriller','Comédie','Fantastique','SF'];

        foreach($categories as $categorieFor){

            $categorie = new Categorie;

            $categorie->setTitre($categorieFor);

            //$manager->persist($categorie);
            //$manager->flush();

        }

    }
}

?>