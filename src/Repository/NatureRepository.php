<?php

namespace App\Repository;

use App\Entity\Nature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nature>
 *
 * @method Nature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nature[]    findAll()
 * @method Nature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nature::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Nature $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Nature $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
     * @return une query de doctrine pour la pagination.
    */
    
     public function paginationQuery()
    {
        return $this->paginationQuery('n')
            ->orderBy('n.id', 'ASC')
            ->getQuery()
        ;
    }

    /*public function paginationQuery(int $page, string $slug, int $limit = 2):array
    {
        $limit = abs($limit);

        $result = [];//On met les résultats ds un tableau

        $query = $this->getEntityManager()->createQueryBuilder()
         ->select

        
        
    }*/

     // /**
    //  * @return Nature[] Returns an array of Nature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nature
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
   
   /* public function Category($value): ?Nature
    {
        $queryBuilder = $entityManager()->createQueryBuilder();
        $query= $entityManager()->createQuery(
            //SELECT * FROM A   INNER JOIN B ON A.key = B.key
            'SELECT To_belong
             FROM App\Entity\Nature 
             
             '
        );

        $query=getResult();
    }
    
    */
}
