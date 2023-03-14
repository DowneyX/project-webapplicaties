<?php

namespace App\Repository;

use App\Entity\FaultyMeasurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FaultyMeasurement>
 *
 * @method FaultyMeasurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaultyMeasurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaultyMeasurement[]    findAll()
 * @method FaultyMeasurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaultyMeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaultyMeasurement::class);
    }

    public function save(FaultyMeasurement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FaultyMeasurement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FaultyMeasurement[] Returns an array of FaultyMeasurement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FaultyMeasurement
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
