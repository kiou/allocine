<?php

namespace App\Repository\Page;

use App\Entity\Page\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Menu::class);
	}
	
	public function getAllMenuAdmin($parent = null, $langue, $admin)
    {

        /* Requéte */
        $qb = $this->createQueryBuilder('m');

        if(is_null($parent)){
            $qb->andWhere('m.parent = 0');
        }else{
            $qb->andWhere('m.parent = :parent')
                ->setParameter('parent', $parent);
        }

        /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('m.langue = :langue')
               ->setParameter('langue', $langue);
        }

        if(!$admin){
            $qb->andWhere('m.isActive = 1');
        }

        $qb->orderBy('m.poid', 'ASC');

        return $query = $qb->getQuery()->getResult();

    }

}
