<?php

namespace App\Repository\Film;

use App\Entity\Film\Film;
use App\Entity\Diaporama\Galerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function getAllFilms($recherche = null, $langue = null)
    {

        $qb = $this->createQueryBuilder('f');

        /**
         * recherche via le titre
         */
        if(!empty($recherche)){
            $qb->andWhere('f.titre LIKE :recherche')
               ->setParameter('recherche', '%'.$recherche.'%');
        }

         /**
         * recherche via la langue
         */
        if(!empty($langue)){
            $qb->andWhere('f.langue = :langue')
               ->setParameter('langue', $langue);
        }

        $qb->orderBy('f.id', 'DESC');

        return $query = $qb->getQuery()->getResult();

    }

    public function allFilmSearch($categorie = null, $souscategorie = null, $acteur = null)
    {

        $qb = $this->createQueryBuilder('f');

        /**
         * Recherche vie la catégorie
         */
        if(!empty($categorie)){
            $qb->andWhere('f.categorie = :categorie')
               ->setParameter('categorie', $categorie);
        }

        /**
         * Recherche vie la sous catégorie
         */
        if(!empty($souscategorie)){
            $qb->andWhere('f.souscategorie = :souscategorie')
               ->setParameter('souscategorie', $souscategorie);
        }

         /**
         * Recherche vie l'acteur
         */
        if(!empty($acteur)){
            $qb->join('f.acteurs', 'a')
                ->select('a, f')
                ->andWhere('a.id = :acteur')
                ->setParameter('acteur',$acteur);
        }

        return $query = $qb->getQuery()->getResult();

    }

    public function getSingleFilm($id){

        $qb = $this->createQueryBuilder('f');

        $qb->leftJoin('f.galeriefilm', 'g', Expr\Join::WITH, 'g.isActive = :bool')
           ->setParameter('bool', true)
           ->addSelect('g');

        $qb->leftJoin('g.images', 'i', Expr\Join::WITH, 'i.isActive = :bool' )
           ->setParameter('bool', true)
           ->orderBy('i.poid','DESC')
           ->addSelect('i');

        $qb->andWhere('f.id = :id')
           ->setParameter('id', $id);
        
        return $query = $qb->getQuery()->getSingleResult();

    }

}
