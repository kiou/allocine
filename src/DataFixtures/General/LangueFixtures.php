<?php

namespace App\DataFixtures\General;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\General\Langue;

class LangueFixtures extends Fixture
{

	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadLangues($manager);
    }

    public function loadLangues(ObjectManager $manager)
    {
        $langue = new Langue();

        /* Infos de base */
        $langue->setNom('Français');
        $langue->setCode('fr');

        //$manager->persist($langue);
        //$manager->flush();
    }
}

?>