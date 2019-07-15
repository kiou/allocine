<?php

namespace App\Repository\Actualite;

use App\Entity\Actualite\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actualite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualite[]    findAll()
 * @method Actualite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actualite::class);
    }

    public function getAllActualites($recherche = null, $langue = null, $categorie = null, $admin = false, $limit = null)
    {
        $qb = $this->createQueryBuilder('a');

        /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('a.titre LIKE :recherche')
               ->setParameter('recherche', '%'.$recherche.'%');
        }

        /**
         * recherche via la catégorie
         */
        if(!empty($categorie)){
            $qb->andWhere('a.categorie = :categorie')
               ->setParameter('categorie', $categorie);
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('a.langue = :langue')
               ->setParameter('langue', $langue);
        }

        if($admin) $qb->orderBy('a.id', 'DESC');
        else{
            $qb->andWhere('a.isActive =  :isActive')
               ->setParameter('isActive', true)
               ->andWhere('a.avant LIKE :avant')
               ->setParameter('avant', false)
               ->andWhere('a.debut <=  :debut')
               ->setParameter('debut', new \DateTime('now'))
               ->orderBy('a.poid', 'DESC');
        }

        if(!empty($limit)){
            $qb->setMaxResults($limit);
        }

        return $query = $qb->getQuery()->getResult();
    }

    public function getAvantActualite($langue)
    {
        $qb = $this->createQueryBuilder('a')
                   ->andWhere('a.isActive =  :isActive')
                   ->setParameter('isActive', true)
                   ->andWhere('a.avant LIKE :avant')
                   ->setParameter('avant', true)
                   ->andWhere('a.debut <=  :debut')
                   ->setParameter('debut', new \DateTime('now'))
                   ->andWhere('a.langue = :langue')
                   ->setParameter('langue', $langue)
                   ->setMaxResults(1)
                   ->orderBy('a.poid', 'DESC');

        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    public function getCurrentActualite($id)
    {
        $qb = $this->createQueryBuilder('a')
                   ->andWhere('a.isActive =  :isActive')
                   ->setParameter('isActive', true)
                   ->andWhere('a.debut <=  :debut')
                   ->setParameter('debut', new \DateTime('now'))
                   ->andWhere('a.id = :id')
                   ->setParameter('id', $id);

        return $query = $qb->getQuery()->getOneOrNullResult();

    }

}
