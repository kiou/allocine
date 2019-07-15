<?php

namespace App\DataFixtures\Film;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Film\Categorie;
use App\Entity\Film\SousCategorie;
use App\DataFixtures\Film\CategorieFixtures;

class SousCategorieFixtures extends Fixture
{

	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadSousCategories($manager);
    }

    public function loadSousCategories(ObjectManager $manager)
    {

        $souscategories = [
            ['1' => 'Polar 1'],
            ['1' => 'Polar 2'],
            ['2' => 'Drame 1'],
            ['2' => 'Drame 2'],
            ['2' => 'Drame 3'],
            ['3' => 'Thriller 1'],
            ['3' => 'Thriller 2'],
            ['3' => 'Thriller 3'],
            ['4' => 'Comédie 1'],
            ['4' => 'Comédie 2'],
            ['5' => 'Fantastique 1'],
            ['5' => 'Fantastique 2'],
            ['5' => 'Fantastique 3'],
            ['6' => 'SF 1'],
            ['6' => 'SF 2'] 
        ];

        foreach ($souscategories as $souscategorie){

            foreach($souscategorie as $key => $value){

                $SousCategorie = new SousCategorie;

                $categorieEntity = $manager->getRepository(Categorie::class)->find($key);
                $SousCategorie->setCategorie($categorieEntity);
                $SousCategorie->setTitre($value);

                //$manager->persist($SousCategorie);
                //$manager->flush();
            }

        }

    }

    public function getDependencies()
    {
        return array(
            CategorieFixtures::class,
        );
    }

}

?>