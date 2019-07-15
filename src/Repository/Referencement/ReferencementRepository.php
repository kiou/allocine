<?php

namespace App\Repository\Referencement;

use App\Entity\Referencement\Referencement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Referencement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referencement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referencement[]    findAll()
 * @method Referencement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferencementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Referencement::class);
    }
}
