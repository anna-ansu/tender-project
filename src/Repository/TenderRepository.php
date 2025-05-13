<?php

namespace App\Repository;

use App\Entity\Tender;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tender>
 */
class TenderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tender::class);
    }

    public function getQueryBuilderByFilters(?string $name, ?string $date)
    {
        $qb = $this->createQueryBuilder('t');

        if ($name) {
            $qb->andWhere('t.name LIKE :name')
                ->setParameter('name', '%' . $name . '%');
        }

        if ($date) {
            $start = new DateTime($date . ' 00:00:00');
            $end = new DateTime($date . ' 23:59:59');

            $qb->andWhere('t.updatedAt BETWEEN :start AND :end')
                ->setParameter('start', $start)
                ->setParameter('end', $end);
        }

        return $qb;
    }

    //    /**
    //     * @return Tender[] Returns an array of Tender objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tender
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
