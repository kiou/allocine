<?php

namespace App\Repository\Film;

use App\Entity\Film\SousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SousCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategorie[]    findAll()
 * @method SousCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategorieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SousCategorie::class);
    }

    public function getByCategorie($categorie, $queryFast = false)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->where('s.categorie = :categorie')
           ->setParameter('categorie',$categorie);

        $qb->orderBy('s.id', 'ASC');
        
        if($queryFast) return $qb;

        return $qb->getQuery()->getResult();
    }

}
