<?php

namespace App\Repository;

use App\Entity\DietPlanDatabase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DietPlanDatabase>
 *
 * @method DietPlanDatabase|null find($id, $lockMode = null, $lockVersion = null)
 * @method DietPlanDatabase|null findOneBy(array $criteria, array $orderBy = null)
 * @method DietPlanDatabase[]    findAll()
 * @method DietPlanDatabase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DietPlanDatabaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DietPlanDatabase::class);
    }

    public function save(DietPlanDatabase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DietPlanDatabase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DietPlanDatabase[] Returns an array of DietPlanDatabase objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DietPlanDatabase
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
