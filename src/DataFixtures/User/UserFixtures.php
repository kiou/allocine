<?php

namespace App\DataFixtures\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User\User;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();

        $user->setNickname('admin');
        $user->setNom('nom');
        $user->setPrenom('prenom');
        $user->setEmail('admin@colocarts.com');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setIsActive(true);
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'admin'));

        //$manager->persist($user);
        //$manager->flush();
    }
    
}

?>