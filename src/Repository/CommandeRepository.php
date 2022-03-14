<?php


namespace App\Repository;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    private function _getQbWithSearch($keyword) {
        // SELECT * FROM Commande as c
        // WHERE deleted = 0 AND (c.NOM LIKE :p1 OR ...)
        // créer le constructeur de requete
        $qb = $this->createQueryBuilder('c');
        if($keyword) {
            $qb->andWhere('c.reference LIKE :p1');
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
