<?php

namespace App\Repository\User;

use App\Entity\User\Reinitialisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reinitialisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reinitialisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reinitialisation[]    findAll()
 * @method Reinitialisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReinitialisationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reinitialisation::class);
    }
}
