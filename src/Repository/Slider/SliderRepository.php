<?php

namespace App\Repository\Slider;

use App\Entity\Slider\Slider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Slider|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slider|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slider[]    findAll()
 * @method Slider[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Slider::class);
    }

    public function getAllSliders($recherche, $langue)
    {
        $qb = $this->createQueryBuilder('s');

        /**
         * recherche via le username
         */
        if(!is_null($recherche)){
            $qb->andWhere('s.titre LIKE :titre')
                ->setParameter('titre', '%'.$recherche.'%');
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('s.langue = :langue')
               ->setParameter('langue', $langue);
        }

        $qb->orderBy('s.id', 'DESC');

        return $query = $qb->getQuery()->getResult();
    }
}
