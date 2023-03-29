<?php

namespace App\Repository;

use App\Entity\Water;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Water>
 *
 * @method Water|null find($id, $lockMode = null, $lockVersion = null)
 * @method Water|null findOneBy(array $criteria, array $orderBy = null)
 * @method Water[]    findAll()
 * @method Water[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WaterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Water::class);
    }

    public function save(Water $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Water $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWater(int $id): array
    {
        $entitymanager = $this->getEntityManager();

        $query = $entitymanager->createQuery(
            'SELECT distinct w.Image, w.WaterName, w.Price, w.Description, i.Name, g.GenreName
             FROM App\Entity\Water w, App\Entity\Inventor i, App\Entity\Genre g
             WHERE w.id = :id
             AND w.inventor = i.id AND w.genre = g.id'
        )->setParameter('id', $id);
        return $query->getResult();
    }

//    /**
//     * @return Water[] Returns an array of Water objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Water
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
