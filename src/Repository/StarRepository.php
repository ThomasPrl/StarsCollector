<?php

namespace App\Repository;

use App\Entity\Star;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Star>
 *
 * @method Star|null find($id, $lockMode = null, $lockVersion = null)
 * @method Star|null findOneBy(array $criteria, array $orderBy = null)
 * @method Star[]    findAll()
 * @method Star[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Star::class);
    }

    public function save(Star $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Star $entity, bool $flush = false): void
    {
        $SkyRepository = $this->getEntityManager()->getRepository(Sky::class);

        // get rid of the ManyToMany relation with [galeries]
        $skies = $SkyRepository->findStarSkies($entity);   
        foreach($skies as $sky) {
            $sky->removeStar($entity);
            $this->getEntityManager()->persist($sky);
        }

        // get rid of the ManyToMany relation with the [Category1] and [objet]
        $types = $entity->getTypes();
        foreach($types as $type) {
            $entity->removeType($type);
            $this->getEntityManager()->persist($type);
        }

        $this->getEntityManager()->remove($entity);

        if ($flush) {
              $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Star[] Returns an array of Star objects for a member
     */
    public function findMemberStars($member): array
    {
        return $this->createQueryBuilder('o')
            ->leftJoin('o.space', 'i')
            ->andWhere('i.member = :member')
            ->setParameter('member', $member)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Star
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
