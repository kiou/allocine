<?php

namespace App\Repository\Evenement;

use App\Entity\Evenement\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function getAllEvenements($recherche = null, $langue = null, $categorie = null, $admin = false, $limit = null)
    {
        $qb = $this->createQueryBuilder('e');

        /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('e.titre LIKE :recherche')
                ->setParameter('recherche', '%'.$recherche.'%');
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('e.langue = :langue')
               ->setParameter('langue', $langue);
        }

        /**
         * recherche via la catégorie
         */
        if(!empty($categorie)){
            $qb->andWhere('e.categorie = :categorie')
                ->setParameter('categorie', $categorie);
        }

        if($admin) $qb->orderBy('e.id', 'DESC');
        else{
            $qb->andWhere('e.isActive =  :isActive')
               ->setParameter('isActive', true)
               ->andWhere('e.avant = :avant')
               ->setParameter('avant', false)
               ->andWhere('e.fin >=  :fin')
               ->setParameter('fin', new \DateTime('now'))
               ->orderBy('e.debut', 'ASC');
        }

        if(!empty($limit)){
            $qb->setMaxResults($limit);
        }

        return $query = $qb->getQuery()->getResult();
    }

    public function getAllEvenementsCalendrier($langue)
    {
        $qb = $this->createQueryBuilder('e')
                   ->andWhere('e.isActive =  :isActive')
                   ->setParameter('isActive', true)
                   ->andWhere('e.fin >= :fin')
                   ->setParameter('fin', new \DateTime('now'))
                   ->andWhere('e.langue = :langue')
                   ->setParameter('langue', $langue)
                   ->orderBy('e.debut', 'ASC');

        return $query = $qb->getQuery()->getResult();
    }

    public function getAvantEvenement($langue)
    {
        $qb = $this->createQueryBuilder('e')
                   ->andWhere('e.isActive =  :isActive')
                   ->setParameter('isActive', true)
                   ->andWhere('e.avant = :avant')
                   ->setParameter('avant', true)
                   ->andWhere('e.fin >=  :fin')
                   ->setParameter('fin', new \DateTime('now'))
                   ->andWhere('e.langue = :langue')
                   ->setParameter('langue', $langue)
                   ->setMaxResults(1)
                   ->orderBy('e.debut', 'ASC');

        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    public function getCurrentEvenement($id)
    {
        $qb = $this->createQueryBuilder('e')
                   ->andWhere('e.isActive =  :isActive')
                   ->setParameter('isActive', true)
                   ->andWhere('e.fin >=  :fin')
                   ->setParameter('fin', new \DateTime('now'))
                   ->andWhere('e.id = :id')
                   ->setParameter('id', $id);

        return $query = $qb->getQuery()->getOneOrNullResult();

    }
    
}
