<?php

namespace App\Repository\Contact;

use App\Entity\Contact\Objet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Objet::class);
    }
    
    public function getAllObjets($langue, $form = false)
    {
        $qb = $this->createQueryBuilder('o');

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('o.langue = :langue')
                ->setParameter('langue', $langue);
        }

        $qb->orderBy('o.id', 'DESC');

        if($form) return $qb;

        return $query = $qb->getQuery()->getResult();
    }

}
