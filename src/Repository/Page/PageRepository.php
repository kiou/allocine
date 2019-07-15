<?php

namespace App\Repository\Page;

use App\Entity\Page\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }
    
    public function getAllPages($recherche, $langue)
    {
        $qb = $this->createQueryBuilder('p');

        /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('p.titre LIKE :titre')
               ->setParameter('titre', '%'.$recherche.'%');
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('p.langue = :langue')
               ->setParameter('langue', $langue);
        }

        $qb->orderBy('p.id', 'DESC');

        return $query = $qb->getQuery()->getResult();
    }

}
