<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    private function _getQbWithSearch($keyword) {
        // SELECT * FROM Produit as p
        // WHERE deleted = 0 AND (c.NOM LIKE :p1 OR ...)
        // créer le constructeur de requete
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.deleted = 0');
        if($keyword) {
            $qb->andWhere('p.nom LIKE :p1 OR p.description LIKE :p1 OR p.reference LIKE :p1');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }

    public function countBySearch($keyword)
    {
        $qb = $this->_getQbWithSearch($keyword);
        $qb->select('count(p.id)');
        // permet de récupérer une valeur unique et non un objet ou une collection
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countByRef($ref) {
        $qb = $this->createQueryBuilder('p');
        $qb->where('p.reference LIKE :p1');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(p.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findBySearch($offset, $limit, $keyword) {
        $qb = $this->_getQbWithSearch($keyword);
        // offset
        $qb->setFirstResult($offset)
            // limit
            ->setMaxResults($limit);

        $qb->orderBy('p.reference');
        // getResult() // recuperer une liste de resultat
        // getOneOrNullResult() // recuperer le premier resultat
        return $qb->getQuery()->getResult();
    }



}
