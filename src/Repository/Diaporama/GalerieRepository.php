<?php

namespace App\Repository\Diaporama;

use App\Entity\Diaporama\Galerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Galerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Galerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Galerie[]    findAll()
 * @method Galerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalerieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Galerie::class);
    }

    public function getAllGaleries($recherche = null, $categorie = null, $langue = null, $admin = false, $limit = null)
    {
        $qb = $this->createQueryBuilder('g');

        /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('g.titre LIKE :recherche')
               ->setParameter('recherche', '%'.$recherche.'%');
        }

        /**
         * recherche via la catégorie
         */
        if(!empty($categorie)){
            $qb->andWhere('g.categorie = :categorie')
               ->setParameter('categorie', $categorie);
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('g.langue = :langue')
               ->setParameter('langue', $langue);
        }

        if($admin) $qb->orderBy('g.id', 'DESC');
        else{
            $qb->andWhere('g.isActive =  :isActive')
               ->setParameter('isActive', true)
               ->orderBy('g.poid', 'DESC');
        }

        if(!empty($limit)){
            $qb->setMaxResults($limit);
        }

        return $query = $qb->getQuery()->getResult();
    }

    public function getCurrentGalerie($id)
    {
        $qb = $this->createQueryBuilder('g')
            ->leftjoin('g.images', 'i', Join::WITH, 'i.isActive = :isActive')
            ->select('g, i')
            ->andWhere('g.isActive =  :isActive')
            ->andWhere('g.id = :id')
            ->setParameter('isActive', true)
            ->setParameter('id', $id)
            ->addOrderBy('i.poid', 'DESC');

        return $query = $qb->getQuery()->getOneOrNullResult();

    }

}
