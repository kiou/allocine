<?php

namespace App\Repository\Evenement;

use App\Entity\Evenement\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function getAllCategorie($langue)
    {
        $qb = $this->createQueryBuilder('c');

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('c.langue = :langue')
               ->setParameter('langue', $langue);
        }

        $qb->orderBy('c.id', 'DESC');

        return $query = $qb->getQuery()->getResult();
    }
    
}
