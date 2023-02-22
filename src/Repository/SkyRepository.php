<?php

namespace App\Repository;

use App\Entity\Sky;
use App\Entity\Star;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sky>
 *
 * @method Sky|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sky|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sky[]    findAll()
 * @method Sky[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sky::class);
    }

    public function save(Sky $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sky $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Sky[] Returns an array of Sky objects
     */
    public function findStarSkies(Star $star): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.stars', 'o')
            ->andWhere('g.stars', 'o')
            ->setParameter('star', $star)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Sky
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
