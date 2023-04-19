<?php

namespace App\Repository;

use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measurement>
 *
 * @method Measurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Measurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Measurement[]    findAll()
 * @method Measurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurement::class);
    }

    public function save(Measurement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Measurement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByCurrentWeek(Station $station): array
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->where('u.station = :station')
            ->setParameter('station', $station->getId())
            ->andWhere('u.timestamp >= :start')
            ->andWhere('u.timestamp <= :end')
            ->setParameter('start', date("Y-m-d", strtotime('monday this week')))
            ->setParameter('end', date("Y-m-d", strtotime('sunday this week')))
            ->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return Measurement[] Returns an array of Measurement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Measurement
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
