<?php

namespace App\Repository\Personne;

use App\Entity\Personne\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function getAllPersonnes($recherche = null){

        $qb = $this->createQueryBuilder('p');

         /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('p.prenom LIKE :recherche')
               ->orWhere('p.nom LIKE :recherche') 
               ->setParameter('recherche', '%'.$recherche.'%');
        }

        $qb->orderBy('p.id', 'DESC');

        return $query = $qb->getQuery()->getResult();

    }
}
