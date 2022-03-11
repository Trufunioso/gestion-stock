<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    private function _getQbWithSearch($keyword) {
        // SELECT * FROM Client as c
        // WHERE deleted = 0 AND (c.NOM LIKE :p1 OR ...)
        // créer le constructeur de requete
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.deleted = 0');
        if($keyword) {
            $qb->andWhere('c.nom LIKE :p1 OR c.prenom LIKE :p1 OR c.reference LIKE :p1');
            $qb->setParameter('p1', $keyword . '%');
        }
        return $qb;
    }

    public function countBySearch($keyword)
    {
        $qb = $this->_getQbWithSearch($keyword);
        $qb->select('count(c.id)');
        // permet de récupérer une valeur unique et non un objet ou une collection
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function countByRef($ref) {
        $qb = $this->createQueryBuilder('c');
        $qb->where('c.reference LIKE :p1');
        $qb->setParameter('p1', $ref . '%');
        $qb->select('COUNT(c.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findBySearch($offset, $limit, $keyword) {
         $qb = $this->_getQbWithSearch($keyword);
         // offset
         $qb->setFirstResult($offset)
             // limit
             ->setMaxResults($limit);

         $qb->orderBy('c.reference');
         // getResult() // recuperer une liste de resultat
        // getOneOrNullResult() // recuperer le premier resultat
         return $qb->getQuery()->getResult();
    }


}
