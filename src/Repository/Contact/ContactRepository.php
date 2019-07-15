<?php

namespace App\Repository\Contact;

use App\Entity\Contact\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function getAllContacts($objet, $langue)
    {
        $qb = $this->createQueryBuilder('c');

        /**
         * recherche via l'objet
         */
        if(!empty($objet)){
            $qb->andWhere('c.objet = :objet')
               ->setParameter('objet', $objet);
        }

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
