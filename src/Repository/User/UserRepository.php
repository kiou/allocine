<?php

namespace App\Repository\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUser($recherche)
	{
		$qb = $this->createQueryBuilder('u');

		/**
		 * recherche dans le nom ou le prénom
		 */
		if(!is_null($recherche)){
			$qb->andWhere("CONCAT(u.nom, ' ',u.prenom) LIKE :recherche OR CONCAT(u.prenom, ' ',u.nom) LIKE :recherche")
			   ->setParameter('recherche', '%'.$recherche.'%');
		}
		
		$qb->orderBy('u.id', 'DESC');

		return $query = $qb->getQuery()->getResult();
	}
}
